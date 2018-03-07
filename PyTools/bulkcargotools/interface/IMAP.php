<?php
error_reporting(E_ALL);
echo "Started <br>";
header("Pragma: no-cache");
define("DEBUG_MODE",	1);

//require_once("config.php");

ini_set('memory_limit', '1024M');
set_time_limit(540);

// Connection details for database server
$hostname = '{outlook.office365.com:993/imap/ssl/user=MunsterUniversity@24Vision.Solutions\Chartering}';
$username = 'MunsterUniversity@24Vision.Solutions';
$password = 'Mun@24V-112017';


// Connection details for imap server
$dbServername = '24v-azu-db001.mysql.database.azure.com';
$dbUsername = 'dev_cargoinship_service@24v-azu-db001';
$dbPassword = 'cM2ur5FdIqh6';
$dbPort = '3306';
$dbName = 'dev_dbpsbulkcargo';

$db = null;
$inbox = null;

$db = enableDBConnection($dbServername, $dbUsername, $dbPassword, $dbName, $dbPort);

$inbox = enableIMAPConnection($db, $hostname, $username, $password);
$stmt = prepareSQLStatement($db);
accessEmails($db, $inbox, $stmt);
imap_close($inbox);
$db = null;

/*
 * enableDBConnection tries to connect to database by creating a new database object
 * If this fails an exeception will be thrown and the error message will be printed to the screen
 * @return: $db -> database object
 */
function enableDBConnection($dbServername, $dbUsername, $dbPassword, $dbName, $dbPort)
{
    /* try to connect to database */
    $db = null;
    try {
        $db = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName, $dbPort);
        message("Connection established. \n");
    } catch (mysqli_sql_exception $e) {
        die('Connection failed: ' . $e->getMessage());
    }
    return $db;
}

/*
 * enableIMAPConnection tries to connect to the imap server using the connection details
 * If it is not possible to connect to the imap server an exception is thrown on the on hand
 * print it on the screen and on the other hand store the error into the database. This is done by
 * connectServerErros to have a log about errors.
 * In the next step it is checked, if the inbox contains emails otherwise the script is closed.
 */
function enableIMAPConnection($db, $hostname, $username, $password)
{
    $inbox = null;
    /* try to connect to imap server */
    try {
        $inbox = imap_open($hostname, $username, $password, NULL,  1, array('DISABLE_AUTHENTICATOR' => 'PLAIN'));
        message($hostname . " " . $username . " " . $password);
    } catch (Exception $e) {
        message("Not connected to Imap server!");
        connectServerErrors($db);
        die('Cannot connect to IMAP: ' . imap_last_error());
    }
    if ($inbox == null) {
        print_r(imap_errors());
        connectServerErrors();
        die('Inbox empty \n');
    }
    
    return $inbox;
}

/*
 * prepareSQLStatement
 * @input: $db -> databaseObject
 * Try to prepare an sql statement to write into the email table of the database
 * This should contain the subject, body, sender, receiver, date, and imapuid
 * If not possible to prepare statement, then die and display the error
 * @return: Prepared statement
 */
function prepareSQLStatement($db)
{
    if (! $stmt = $db->prepare("INSERT INTO psbcm.email (subject, body, sender, receiver ,date, imapuid) VALUES (?,?,?,?,?,?)")) {
        message("Prepare failed in prepareSQLStatement: (" . $db->errno . ") " . $db->error);
    }
    else {
        message("Prepared success! <br>");
    }
    
    return $stmt;
}

/*
 * access emails
 * @input: $db -> database Object
 * @input: $inbox -> imap stream
 * @input: $stmt -> prepared sql statement
 * This function first grabs emails calls grab emails which returns all emails that belong to a specific filter
 * If emails are return they are first sorted and then the function emailArray is called which saves the content of
 * the email into an array
 */
function accessEmails($db, $inbox, $stmt)
{
    $emails = grabEmails($inbox);
    if ($emails) {
        sort($emails);
        emailArray($db, $inbox, $emails, $stmt);
    }
    
}

/*
 * connectServerErrors
 * @input: $db -> database Object
 * This function writes occuring errors with the imap stream into the email_imap_error database table
 */
function connectServerErrors($db)
{
    if (imap_errors()) {
        ob_start();
        $errorlog = imap_errors();
        for ($i = 0; $i < $errorlog . length; $i ++) {
            ob_flush();
            $insertSQL = "INSERT INTO `bcm`.`email_imap_error`(`errorMessage`) VALUES ('" . $errorlog[i] . "');";
            message($insertsql);
            
            if ($db->query($insertSQL)) {
                message("inserted mail: " . $imapuid);
            } else {
                message('Error: ' . $imapuid . '<br>' . mysqli_error($db) . '<br>');
            }
        }
    }
}

/* grab emails needs to be extended, when php script allows communication with the user to execute the lower statements */
function grabEmails($inbox)
{
    if ($inbox == null) {
        message('Connection error: Inbox empty');
        $emails = array();
    } else {
        $emails = imap_search($inbox, 'UNSEEN');
        if ($_GET["filter"] == "unseen") {
            $emails = imap_search($inbox, 'UNSEEN');
        } elseif ($_GET["filter"] == "new") {
            $emails = imap_search($inbox, 'NEW');
        } elseif ($_GET["filter"] == "recent") {
            $yesterday = strtotime("-1 day");
            $yesterday_str = date('Y-m-d', $yesterday);
            $criterion = ' SINCE "' . $yesterday_str . '" ';
            $emails = imap_search($inbox, $criterion);
        } elseif ($_GET["filter"] == "all") {
            $emails = imap_search($inbox, 'ALL');
        } elseif ($_GET["filter"] == "search" && isset($_GET["keyword"])) {
            $emails = imap_search($inbox, 'TEXT "' . urldecode($_GET["keyword"] . '"'));
        }
    }
    return $emails;
}

/*
 * emailArray
 * @input: $db -> database Object
 * @input: $inbox -> imap stream
 * @input: $emails -> array of emails
 * @input: $stmt -> prepared sql statement
 * This function cycles through every email of the array and stores the information needed for the database into a new
 * array ($email). Then it calls functions insertEmail and insertAttachment to write details into the database
 */
function emailArray($db, $inbox, $emails, $stmt)
{
    /* for every email... */
    foreach ($emails as $key => $email_number) {
        ob_start();
        /* get information specific to this email */
        $overview = imap_fetch_overview($inbox, $email_number, 0);
        $outputArray = getMessage($inbox, $email_number);
        /* Store all needed parts of the email into an array with the respective type */
        $email = array();
        $email["Subject"] = imap_utf8($overview[0]->subject);
        $email["Body"] = getPlainText($email_number, $outputArray);
        $email["From"] = $overview[0]->from;
        if (! isset($overview[0]->to))
            $email["To"] = null;
            else
                $email["To"] = $overview[0]->to;
                
                
                $email["Date"] = formatDate($overview[0]->date);
                
                $email["IMAPUID"] = $overview[0]->uid;
                ob_flush();
                
                /* access functions to insert the email into the database as well as attachment to server and database */
                insertEmail($db, $inbox, $email, $stmt);
                insertAttachment($db, $email_number, $outputArray, $email["IMAPUID"]);
    }
}

function formatDate($date) {
    //Date Preperation
    if (is_numeric(substr($date, 0, 2))) {
        //Inverse first numbers
        $firstnumber = substr($date, 0, 2);
        $secondnumber = substr($date, 3, 2);
        $datestring = $secondnumber . "." . $firstnumber . "." . substr($row["date"], 6, strlen($date) - 6);
    } else {
        $replacements = array("Mon,", "Tue, ", "Wed, ", "Thu, ", "Fri, ", "Sat, ", "Sun, ");
        $datestring = str_replace($replacements, "", $date);
    }
    
    $timestamp = strtotime($datestring);
    $newdate = date("Y-m-d H:i:s", $timestamp);
    return $newdate;
}

/*
 * getMessage
 * @input: $inbox -> imapStream
 * @input: $email_number -> number of the considered email in the $emails array
 * This function returns the body of the email. There are different cases existing of where content is located in the body
 * In this case we consider only Case 1: Text, and Case 7: Other Attachment
 * @return: $output -> array containing text and optional attachments with filename and attachment
 */
function getMessage($inbox, $email_number)
{
    /*
     * get the structure of the email body.
     * If the body has more than one part first flatten the Parts to make it easier accessible
     * and then cycle through each part of the body to extract the respective parts
     */
    $structure = imap_fetchstructure($inbox, $email_number);
    print_r ($structure);
    $output = array();
    if (isset($structure->parts)) {
        $flattenedParts = flattenParts($structure->parts);
        
        foreach ($flattenedParts as $partNumber => $part) {
            
            switch ($part->type) {
                
                case 0:
                    // the HTML or plain text part of the email
                    $message = getPart($inbox, $email_number, $partNumber, $part->encoding);
                    echo "HTML/Plain Text Message: " .$message . "<br><br>";
                    $output[$email_number][$partNumber]["Text"] = $message;
                    break;
                    
                case 1:
                    // multi-part headers, can ignore
                    
                    break;
                case 2:
                    // attached message headers, can ignore
                    break;
                    
                case 3: // application
                case 4: // audio
                case 5: // image
                case 6: // video
                case 7: // other
                    $filename = getFilenameFromPart($part);
                    if ($filename) {
                        $attachment = getPart($inbox, $email_number, $partNumber, $part->encoding);
                        $output[$email_number][$partNumber]["filename"] = $filename;
                        $output[$email_number][$partNumber]["attachment"] = $attachment;
                    } else {
                        message("Unfortunately " . $output[$email_number][$partNumber] . " is not an attachment <br>");
                    }
                    break;
            }
        }
        echo "Parts Array";
        print_r($output);
        return $output;
    } else {
        /* the email has no parts. Therefore just return the simple text */
        $returnBody = imap_fetchbody($inbox, $email_number, 1);
        echo "<br>No parts emailbody: ". $returnBody . "<br><br>";
        /*
         check if string contains html tags. If yes, call functions strip_html_tags and clean string to avoid any unwanted symbols in the text.
         Otherwise simply return the fetched text as it contains plain text.
         */
        if ($returnBody != strip_tags($returnBody)){
            $returnBody = strip_html_tags($returnBody);
            $returnBody = cleanString($returnBody);
            echo "<br> Striped Text HTML Body: ". $returnBody . "<br><br>";
            
        }
        $output[$email_number][0]["Text"] = $returnBody;
        echo "No parts Array";
        print_r ($output);
        return $output;
        
    }
}

function flattenParts($messageParts, $flattenedParts = array(), $prefix = '', $index = 1, $fullPrefix = true)
{
    foreach ($messageParts as $part) {
        $flattenedParts[$prefix . $index] = $part;
        if (isset($part->parts)) {
            if ($part->type == 2) {
                $flattenedParts = flattenParts($part->parts, $flattenedParts, $prefix . $index . '.', 0, false);
            } elseif ($fullPrefix) {
                $flattenedParts = flattenParts($part->parts, $flattenedParts, $prefix . $index . '.');
            } else {
                $flattenedParts = flattenParts($part->parts, $flattenedParts, $prefix);
            }
            unset($flattenedParts[$prefix . $index]->parts);
        }
        $index ++;
    }
    
    return $flattenedParts;
}

function getPart($connection, $email_number, $partNumber, $encoding)
{
    $data = imap_fetchbody($connection, $email_number, $partNumber);
    switch ($encoding) {
        case 0:
            return $data; // 7BIT
        case 1:
            return $data; // 8BIT
        case 2:
            return $data; // BINARY
        case 3:
            return base64_decode($data); // BASE64
        case 4:
            return quoted_printable_decode($data); // QUOTED_PRINTABLE
        case 5:
            return $data; // OTHER
    }
}

function getFilenameFromPart($part)
{
    $filename = '';
    
    if ($part->ifdparameters) {
        foreach ($part->dparameters as $object) {
            if (strtolower($object->attribute) == 'filename') {
                $filename = $object->value;
            }
        }
    }
    
    if (! $filename && $part->ifparameters) {
        foreach ($part->parameters as $object) {
            if (strtolower($object->attribute) == 'name') {
                $filename = $object->value;
            }
        }
    }
    
    return $filename;
}

function insertEmail($db, $inbox, $email, $stmt)
{
    
    if (! $stmt->bind_param("ssssss", $subject, $body, $from, $to, $date, $imapuid))
        die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
        // get attributes to include into database*/
        $subject = $email["Subject"];
        $body = $email["Body"];
        $from = $email["From"];
        $to = $email["To"];
        $date = $email["Date"];
        $imapuid = $email["IMAPUID"];
        
        if ($stmt->execute())
            message("Inserted mail: " . $imapuid);
            else
                message("Error: " . $imapuid . "<br>" . mysqli_error($db) . "<br>");
                
                $semKey = 1; // Access Key for the Semaphore that is used for database
                // $semaphore = sem_get ( $semKey, 1 ); // returns the semaphore
                // sem_aquire ( $semaphore ); // tries to acquire the semaphore if free
                
                // sem_release ( $semaphore );
                // set Email as Seen on IMAP Server
                //$status = imap_setflag_full($inbox, $imapuid, '\\Seen', ST_UID);
}

/*
 * function insertAttachment
 * @input: database object, actual email unique id, array with whole email body
 * Attachments are stored in the array from [uid][2] on. So it iterates through each attachment
 * until no more attachment can be found.
 * During each iteration the fileDirectory is extracted and the uid, the attachment name and the directory
 * will be stored in the database attachment table.
 * Then the file will be saved at the respective directory
 */
function insertAttachment($db, $email_number, $outputArray, $imapuid)
{
    /*
     * loop through parts 1.x of the email to insert inline attachments. If no attachments are available the inline
     * attachment will be in place array (=> [2] ...) Therefore this loop will print Empty attachment in: ... and finish
     * the loop. Inline attachments will then be inserted in the next while loop of this function
     */
    $content = true;
    $attachmentInd = 1.2;
    while ($content) {
        $attachmentNo = (string) $attachmentInd;
        if (isset($outputArray[$email_number][$attachmentNo])) {
            if (isset($outputArray[$email_number][$attachmentNo]["filename"]) && isset($outputArray[$email_number][$attachmentNo]["attachment"])) {
                $fileDirectory = "./attachments/" . $imapuid . "-" . $outputArray[$email_number][$attachmentNo]["filename"];
                $filename = $outputArray[$email_number][$attachmentNo]["filename"];
                $attachment = $outputArray[$email_number][$attachmentNo]["attachment"];
                
                $sqlCheck = "SELECT * FROM psbcm.attachment WHERE IMAPUID = '" . $imapuid . "' AND attachment = '" . $filename . "'";
                $result = $db->query($sqlCheck);
                if ($result->num_rows > 0){
                    message ("Entry already exists : " . $imapuid . ": " . $filename);
                } elseif ($result->num_rows = 0) {
                    // prepare statement for database introduction
                    if (! $stmt = $db->prepare("INSERT INTO psbcm.attachment (imapUID, attachment, link) VALUES (?,?,?)"))
                        message("Prepare failed: (" . $db->errno . ") " . $db->error);
                        if (! $stmt->bind_param("sss", $imapuid, $filename, $fileDirectory))
                            message("Binding failed: (" . $db->errno . ") " . $db->error);
                            
                            // insert filename and link to file into database
                            if ($stmt->execute())
                                message("Inserted Attachment to database :" . $filename);
                                else
                                    message('Error: ' . $imapuid . '<br>' . mysqli_error($db) . '<br>');
                                    
                                    // save file to server*/
                                    $fp = fopen($fileDirectory, "w+");
                                    fwrite($fp, $attachment);
                                    fclose($fp);
                                    message($filename . " was inserted!");
                }
                $result->close();
            } else
                message("Empty attachment in: " . $imapuid);
        } else {
            $content = false;
        }
        $attachmentInd = $attachmentInd + 0.1;
    }
    
    /*
     * loop through the attachment parts of the mail
     */
    $content = true;
    $attachInd = 2;
    while ($content) {
        $attachNo = (string) $attachInd;
        if (isset($outputArray[$email_number][$attachNo])) {
            if (isset($outputArray[$email_number][$attachNo]["filename"]) && isset($outputArray[$email_number][$attachNo]["attachment"])) {
                $fileDirectory = "./attachments/" . $imapuid . "-" . $outputArray[$email_number][$attachNo]["filename"];
                $filename = $outputArray[$email_number][$attachNo]["filename"];
                $attachment = $outputArray[$email_number][$attachNo]["attachment"];
                
                /* create and run against database if already entries with the given imapuid and filename exist */
                $sqlCheck = "SELECT * FROM psbcm.attachment WHERE IMAPUID = '" . $imapuid . "' AND attachment = '" . $filename . "'";
                $result = $db->query($sqlCheck);
                
                if ($result->num_rows > 0){
                    message ("Entry already exists : " . $imapuid . ": " . $filename);
                } else if ( $result->num_rows == 0){
                    // prepare statement for database introduction
                    if (! $stmt = $db->prepare("INSERT INTO psbcm.attachment (imapUID, attachment, link) VALUES (?,?,?)"))
                        message("Prepare failed: (" . $db->errno . ") " . $db->error);
                        if (! $stmt->bind_param("sss", $imapuid, $filename, $fileDirectory))
                            message("Binding failed: (" . $db->errno . ") " . $db->error);
                            
                            /* insert filename and link to file into database*/
                            if ($stmt->execute())
                                message("Inserted Attachment to database :" . $filename);
                                else
                                    message('Error: ' . $imapuid . '<br>' . mysqli_error($db) . '<br>');
                                    
                                    /* save file to server*/
                                    $fp = fopen($fileDirectory, "w+");
                                    fwrite($fp, $attachment);
                                    fclose($fp);
                                    message($filename . " was saved to filedirectory!");
                }
                $result->close();
            } else
                message("Empty attachment in: " . $imapuid);
        } else
            $content = false;
            $attachInd ++;
    }
}

/*
 * The $outputArray has stored more than just the plain text in the first part. It also stores
 * HTML-Text and inline attachments, which are not necessary to extract. Therefore this function
 * is used. Depending of how many parts the textpart has the plain text has a structure like 1.1.1
 * and so on. Due to the fact that right now we see a max of 1.1.1.1 this is used as first case.
 * If failures appear this is sure extandable by inserting a .1
 * @Return: the plain text stored in the array.
 */
function getPlainText($email_number, $outputArray)
{
    if (isset($outputArray[$email_number]["1.1.1.1"]))
        return $outputArray[$email_number]["1.1.1.1"]["Text"];
        elseif (isset($outputArray[$email_number]["1.1.1"]))
        return $outputArray[$email_number]["1.1.1"]["Text"];
        elseif (isset($outputArray[$email_number]["1.1"]))
        return $outputArray[$email_number]["1.1"]["Text"];
        elseif (isset($outputArray[$email_number]["1"]))
        return $outputArray[$email_number]["1"]["Text"];
        else {
            // $text = strip_html_tags($outputArray[$email_number]["Text"]);
            // $text = ($outputArray[$email]["Text"]);
            return $outputArray[$email_number]["0"]["Text"];
        }
}

function message($msg)
{
    if (DEBUG_MODE == 1) {
        echo $msg . "<br>";
    }
}

function strip_html_tags($str)
{
    $str = preg_replace('/(<|>)\1{2}/is', '', $str);
    $str = preg_replace(array( // Remove invisible content
        '@<head[^>]*?>.*?</head>@siu',
        '@<style[^>]*?>.*?</style>@siu',
        '@<script[^>]*?.*?</script>@siu',
        '@<noscript[^>]*?.*?</noscript>@siu'
    ), "", // replace above with nothing
        $str);
    $str = replaceWhitespace($str);
    $str = strip_tags($str);
    return $str;
}

function replaceWhitespace($str)
{
    $result = $str;
    foreach (array(
        "  ",
        " \t",
        " \r",
        " \n",
        "\t\t",
        "\t ",
        "\t\r",
        "\t\n",
        "\r\r",
        "\r ",
        "\r\t",
        "\r\n",
        "\n\n",
        "\n ",
        "\n\t",
        "\n\r"
    ) as $replacement) {
        $result = str_replace($replacement, $replacement[0], $result);
    }
    return $str !== $result ? replaceWhitespace($result) : $result;
}

function cleanString($str)
{
    $str = str_replace("=C3=9F", "ß", $str);
    $str = str_replace("=C3=BC", "ü", $str);
    $str = str_replace("=C3=A4", "ä", $str);
    $str = str_replace("=3D", "", $str);
    $str = str_replace("&uuml;", "ü", $str);
    $str = str_replace("&auml;", "ä", $str);
    $str = str_replace("&ouml;", "ö", $str);
    $str = str_replace(array(
        "&zwnj;",
        "&nbsp;",
        "&#54;",
        "&#53;",
        "&#52;",
        "&#51;",
        "&#50;",
        "&#49;",
        "&#48;",
        "&#47;",
        "&#56;"
    ), "", $str);
    return $str;
}

?>

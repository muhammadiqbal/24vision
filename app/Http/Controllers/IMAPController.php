<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpImap\Mailbox;
use App\Http\Requests\CreateEmailRequest;

class IMAPController extends Controller
{
    //

    public function inbox(EmailRepository $emailRepo){

//     	[15:47, 2/1/2018] +49 172 4517715: $hostname = '{user=MunsterUniversity@24Vision.Solutions\Chartering}';
// $username = ;
// $password = ;
// $inboxprefix = "24VisionChartering-";
    // Email: Chartering@24Vision.Solutions
    // Imap Server: outlook.office365.com
    // Port: 993
    // User Name: MunsterUniversity@24Vision.Solutions\Chartering
    // SMTP server: smtp.office365.com
    	$mailbox = new Mailbox('{outlook.office365.com}', 'MunsterUniversity@24Vision.Solutions\Chartering', 'Mun@24V-112017', __DIR__);
           // 'Mun@24V-112017', __DIR__);


    	$mailboxes = $mailbox->getMailboxes($search = "*");
    	if($mailboxes){
    		foreach($mailboxes as $mBox){
    			print_r($mBox);
    		}
    	}

    	// Read all messaged into an array:
		$mailsIds = $mailbox->searchMailbox('ALL');
		if(!$mailsIds) {
			die('Mailbox is empty');
		}

        foreach ($mailbox->searchMailbox('ALL'); as $mail) {
            print_r($mail);
            print_r($mail->subject);
            print_r($mail->from);
            print_r($mail->to);
            print_r($mail->cc);
            print_r($mail->getAttachments());
            $input = ['subject'=>$mail->subject,
                    'body'=>$mail,
                    'sender'=>$mail->from,
                    'receiver'=>$mail->to,
                    'cc'=>$mail->cc,
                    'classification_manual'=>,
                    'date'=>,
                    'classification_automated'=>,
                    'IMAPUID'=>,
                    'IMAPFolderID'=>,
                    '_created_on'=>,
                    'classification_automated_certainty'=>,
                    'kibana_extracted'=>false];
          //  $email = $emailRepo->create($input);



        }
		

    }
}

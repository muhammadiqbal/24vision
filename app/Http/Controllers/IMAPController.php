<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpImap\Mailbox;
use App\Repositories\EmailRepository;

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
    	$mailbox = new Mailbox('{outlook.office365.com}', 'MunsterUniversity@24Vision.Solutions', 'Mun@24V-112017', __DIR__);
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

        foreach ($mailbox->searchMailbox('ALL') as $mailId) {
            $email = $mailbox->getMail($mailId);
            print_r($email);
            print_r($email->subject);
            print_r($email->from);
            print_r($email->to);
            print_r($email->cc);
            print_r($email->getAttachments());
            $input = ['subject'=>$email->subject,
                    'body'=>$email,
                    'sender'=>$email->from,
                    'receiver'=>$email->to,
                    'cc'=>$email->cc,
                    'classification_manual'=>null,
                    'date'=>null,
                    'classification_automated'=>null,
                    'IMAPUID'=>null,
                    'IMAPFolderID'=>null,
                    '_created_on'=>null,
                    'classification_automated_certainty'=>null,
                    'kibana_extracted'=>false];
          //  $email = $emailRepo->create($input);



        }
		

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpImap\Mailbox;

class IMAPController extends Controller
{
    //

    public function inbox(){

//     	[15:47, 2/1/2018] +49 172 4517715: $hostname = '{user=MunsterUniversity@24Vision.Solutions\Chartering}';
// $username = ;
// $password = ;
// $inboxprefix = "24VisionChartering-";
    	$mailbox = new Mailbox('{outlook.office365.com}', 'MunsterUniversity@24Vision.Solutions', 'Mun@24V-112017', __DIR__);


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

		// Get the first message and save its attachment(s) to disk:
		$mail = $mailbox->getMail($mailsIds[0]);

		print_r($mail);
		echo "\n\nAttachments:\n";
		print_r($mail->getAttachments());
    }
}

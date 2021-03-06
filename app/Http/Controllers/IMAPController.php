<?php

namespace App\Http\Controllers;

use App\Repositories\EmailRepository;
use App\Models\Email;
use Illuminate\Http\Request;
use PhpImap\Mailbox;
use DB;

class IMAPController extends Controller
{
    //

    public function inbox(Request $request, EmailRepository $emailRepo)
    {
        //read Imap config from .env file
        $hostname = env('IMAP_HOST', '{outlook.office365.com}Test_IMAP');
        $username = env('IMAP_USERNAME', 'MunsterUniversity@24Vision.Solutions');
        $password = env('IMAP_PASSWORD', 'Yoz39332');

    	$mailbox = new Mailbox($hostname, $username, $password, __DIR__);
		$mailsIds = $mailbox->searchMailbox('ALL');
		if(!$mailsIds) {
			$request->session()->flash('error', 'mailbox is empty!');
		}

        $emails = $mailbox->getMailsInfo($mailsIds);
        $saveCount = 0;
    
        foreach ($emails as $email) {
            $input = ['subject'=> @$email->subject,
                    'body'=> quoted_printable_decode(@$mailbox->getMail($email->uid,false)->textPlain),
                    'sender'=> @$email->from,
                    'receiver'=> @$email->to,
                    'cc'=> @$email->cc,
                    'classification_manual'=>null,
                    'date'=> \Carbon\Carbon::parse(@$email->date),
                    'classification_automated'=>null,
                    'IMAPUID'=>env('IMAP_INBOXPREFIX', '24VisionChartering-').$email->uid,
                    'IMAPFolderID'=>null,
                    '_created_on'=>date('Y-m-d'),
                    'classification_automated_certainty'=>null,
                    'kibana_extracted'=>false];
            if(Email::where(env('IMAP_INBOXPREFIX', '24VisionChartering-').$email->uid)->first() == null){
                $storeEmail = $emailRepo->create($input);
                if ($storeEmail) {
                    $saveCount++;
                }
            }

        }
		$request->session()->flash('status', $saveCount.' emails successfully fetched into database!');
       return redirect(route('emails.index'));

    }
}

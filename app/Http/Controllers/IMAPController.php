<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpImap\Mailbox;
use App\Repositories\EmailRepository;
use DB;
use App\Models\Email;

class IMAPController extends Controller
{
    //

    public function inbox(Request $request, EmailRepository $emailRepo){
        $hostname = 'outlook.office365.com:993/imap/ssl/user=MunsterUniversity@24Vision.Solutions\Chartering';
        $username = 'MunsterUniversity@24Vision.Solutions\Chartering';
        $password = 'CHa-062017';
    	//$mailbox = new Mailbox('{outlook.office365.com}INBOX', 'MunsterUniversity@24Vision.Solutions', 'Mun@24V-112017', __DIR__);
        $mailbox = new Mailbox('{'.$hostname.'}INBOX', $username, 'Mun@24V-112017', __DIR__);

		$mailsIds = $mailbox->searchMailbox('ALL');
		if(!$mailsIds) {
			$request->session()->flash('error', 'mailbox is empty!');
		}

        $emails = $mailbox->getMailsInfo($mailsIds);
        $saveCount = 0;
          return 'yeah';     
        foreach ($emails as $email) {
            $input = ['subject'=> @$email->subject,
                    'body'=> quoted_printable_decode(@$mailbox->getMail($email->uid,false)->textPlain),
                    'sender'=> @$email->from,
                    'receiver'=> @$email->to,
                    'cc'=> @$email->cc,
                    'classification_manual'=>null,
                    'date'=> \Carbon\Carbon::parse(@$email->date),
                    'classification_automated'=>null,
                    'IMAPUID'=> @$email->uid,
                    'IMAPFolderID'=>null,
                    '_created_on'=>date('Y-m-d'),
                    'classification_automated_certainty'=>null,
                    'kibana_extracted'=>false];
            if(Email::where('IMAPUID',@$email->uid)->first() == null){
                $storeEmail = $emailRepo->create($input);
                if ($storeEmail) {
                    $saveCount++;
                }
            }

        }
		$request->session()->flash('status', '$saveCount successfully fetched into database!');
       return redirect(route('emails.index'));

    }
}

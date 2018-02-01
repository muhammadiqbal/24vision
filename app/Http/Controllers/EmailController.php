<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Webklex\IMAP\Client;

class EmailController extends Controller
{
    //

    public function index(){
    	/** @var \Webklex\IMAP\Client $oClient */
		$oClient = new Client([
		    'host'          => 'outlook.office365.com',
		   // 'port'          => 993,
		   // 'encryption'    => 'ssl',
		   // 'validate_cert' => true,
		    'username'      => 'MunsterUniversity@24Vision.Solutions',
		    'password'      => 'Mun@24V-112017',
		]);
		$oClient->connect();

		$mbox = imap_open("{outlook.office365.com}", "MunsterUniversity@24Vision.Solutions", "Mun@24V-112017", OP_HALFOPEN)
      or die("can't connect: " . imap_last_error());
		//Get all Mailboxes
		$list = imap_getmailboxes($mbox, '{outlook.office365.com}', 'INBOX/24VisionChartering-*');
		if (is_array($list)) {
		    foreach ($list as $key => $val) {
		        echo "($key) ";
		        echo imap_utf7_decode($val->name) . ",";
		        echo "'" . $val->delimiter . "',";
		        echo $val->attributes . "<br />\n";
		    }
		} else {
		    echo "imap_getmailboxes failed: " . imap_last_error() . "\n";
		}

		  
		//return var_dump();
		//return view('emails.index')->with('emails', $oFolder->getMessages());
    }
}

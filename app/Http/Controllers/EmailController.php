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
		    'host'          => 'outlook.office365.com:993/imap/ssl',
		   // 'port'          => 993,
		   // 'encryption'    => 'ssl',
		   // 'validate_cert' => true,
		    'username'      => 'MunsterUniversity@24Vision.Solutions',
		    'password'      => 'Mun@24V-112017',
		]);
		$oClient->connect();

		/** @var \Webklex\IMAP\Folder $oFolder */
		$oFolder = $oClient->getFolder('INBOX.24VisionChartering-');

		return view('email.index')->with('emails', $oFolder->getMessages());
    }
}

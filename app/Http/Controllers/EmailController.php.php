<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Webklex\IMAP\Client;

class EmailController.php extends Controller
{
    //

    public function index(){
    	/** @var \Webklex\IMAP\Client $oClient */
		$oClient = Client::account('default');
		$oClient->connect();

		/** @var \Webklex\IMAP\Folder $oFolder */
		$oFolder = $oClient->getFolder('INBOX.name');

		return view('email.index')->with('emails', $oFolder->getMessages());
    }
}

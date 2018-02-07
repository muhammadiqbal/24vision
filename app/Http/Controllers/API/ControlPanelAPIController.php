<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use Response;
use Illuminate\Http\Request;


/**
 * Class CargoTypeController
 * @package App\Http\Controllers\API
 */

class ControlPanelAPIController extends AppBaseController
{

	public function execute($script) {
		$command = escapeshellcmd($script);
		$output = shell_exec($command);
		return json($output);
	}

}
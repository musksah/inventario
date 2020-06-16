<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		return view('index');
	}

	public function codeigniter()
	{
		return view('welcome_message');
	}

	public function check_database()
	{

		// ini_set('display_errors', '1');
		// echo '<pre>';
		// $db = \Config\Database::connect();
		$db = ['1','2'];
		print_r($db);
	}


	//--------------------------------------------------------------------

}

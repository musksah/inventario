<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class SessionController extends BaseController
{
    protected $session = null;

	public function __construct()
	{
        $this->session = session();
	}

	public function hasSession()
	{
        return $this->session->has('username');
    }
    
    public function setSession($dataSession){
        $this->session->set($dataSession);
    }

    public function getRol(){
        return $this->session->get('rol');
    }
}

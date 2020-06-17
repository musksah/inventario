<?php

namespace App\Controllers;

use App\Libraries\DataTables;
use CodeIgniter\RESTful\ResourceController;
use App\Controllers\SessionController;

class Users extends ResourceController
{
	protected $modelName = '\App\Models\UserModel';
	protected $format    = 'json';
	private $datatables = null;
	protected $session_controller = null;

	public function __construct()
	{
		$this->datatables = new DataTables();
		$this->session_controller = new SessionController();
	}

	public function index()
	{
		if($this->session_controller->hasSession()){
            $data['rol'] = $this->session_controller->getRol();    
			return view('user/index', $data);
        }
		return view('auth/login');
	}

	public function store()
	{
		$this->configheader();
		$data_insert = $this->request->getPost();
		$data_insert['password'] =  password_hash($data_insert['password'], PASSWORD_DEFAULT);
 		$this->model->create($data_insert);
		return $this->respond(['reponse'=>'Usuario creado correctamente.']);
	}

	public function updating()
	{
		$this->configheader();
		$data_update = $this->request->getPost();
		if(!empty($data_update['password'])){
			$data_update['password'] = password_hash($data_update['password'], PASSWORD_DEFAULT);
		}
		$id = $data_update['id'];
		unset($data_update['id']);
		// echo '<pre>';
		// print_r($data_update);
		// echo ' id '.$id.' ';
		// die;
		$this->model->toUpdate($id,$data_update);
		return $this->respond(['reponse'=>'Usuario actualizado correctamente.']);
	}

	public function list()
	{
		$this->configheader();
		$data = $this->datatables->data($this->model->getAllItems())->makeHeaders()->get();
		return $this->respond($data);
	}

	public function destroy(){
		$this->configheader();
		// echo '<pre>';
		// print_r($id);
		// die;
		$id = $this->request->getPost()['id'];
		// echo $id;
		// die;
		$this->model->destroy($id);
		return $this->respond(['reponse'=>'Usuario desactivado correctamente.']);
	}

	public function configheader(){
		return $this->response->setHeader('Access-Control-Allow-Origin', '*')
		->setHeader('Access-Control-Allow-Headers', '*')
		->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
	}
}

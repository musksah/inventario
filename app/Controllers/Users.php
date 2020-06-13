<?php

namespace App\Controllers;

use App\Libraries\DataTables;
use CodeIgniter\RESTful\ResourceController;

class Users extends ResourceController
{
	protected $modelName = '\App\Models\UserModel';
	protected $format    = 'json';
	private $datatables = null;

	public function __construct()
	{
		$this->datatables = new DataTables();
	}

	public function index()
	{
		return view('user/index');
	}

	public function store()
	{
		$this->configheader();
		$data_insert = $this->request->getPost();
		$this->model->create($data_insert);
		return $this->respond(['reponse'=>'Usuario creado correctamente.']);
	}

	public function list()
	{
		$this->configheader();
		$data = $this->datatables->data($this->model->getAllItems())->makeHeaders()->get();
		return $this->respond($data);
	}

	public function destroy(){
		$this->configheader();
		$id = $this->request->getPost()['id'];
		$this->model->update($id, ['state'=>0]);
		return $this->respond(['reponse'=>'Usuario desactivado correctamente.']);
	}

	public function configheader(){
		return $this->response->setHeader('Access-Control-Allow-Origin', '*')
		->setHeader('Access-Control-Allow-Headers', '*')
		->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
	}
}

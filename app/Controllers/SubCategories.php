<?php

namespace App\Controllers;

use App\Libraries\DataTables;
use App\Libraries\SelectB;
use CodeIgniter\RESTful\ResourceController;

class SubCategories extends ResourceController
{
	protected $modelName = '\App\Models\SubCategoryModel';
	protected $format    = 'json';
	private $datatables = null;
	private $selectb = null;

	public function __construct()
	{
		$this->datatables = new DataTables();
		$this->selectb = new SelectB();
	}

	public function index()
	{
		return view('subcategory/index');
	}

	public function store()
	{
		$this->configheader();
		$data_insert = $this->request->getPost();
		// echo '<pre>';
		// print_r($data_insert);
		// die;
		$this->model->create($data_insert);
		return $this->respond(['reponse'=>'SubCategoría creada correctamente.']);
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
		return $this->respond(['reponse'=>'SubCategoría actualizada correctamente.']);
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
		return $this->respond(['reponse'=>'SubCategoría desactivada correctamente.']);
	}

	public function configheader(){
		return $this->response->setHeader('Access-Control-Allow-Origin', '*')
		->setHeader('Access-Control-Allow-Headers', '*')
		->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
	}
}

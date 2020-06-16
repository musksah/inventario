<?php

namespace App\Controllers;

use App\Libraries\DataTables;
use App\Libraries\SelectB;
use CodeIgniter\RESTful\ResourceController;
use App\Controllers\SessionController;
use App\Models\SubCategoryModel;
use App\Models\SubCategoryProductModel;

class Categories extends ResourceController
{
	protected $modelName = '\App\Models\CategoryModel';
	protected $format    = 'json';
	private $datatables = null;
	private $selectb = null;
	protected $session_controller = null;
	protected $subcategoryModel = null;
	protected $subcategoryProductModel = null;

	public function __construct()
	{
		$this->datatables = new DataTables();
		$this->selectb = new SelectB();
		$this->session_controller = new SessionController();
		$this->subcategoryModel = new SubCategoryModel();
		$this->subcategoryProductModel = new SubCategoryProductModel();
	}

	public function index()
	{
		if($this->session_controller->hasSession()){
            $data['rol'] = $this->session_controller->getRol();    
			return view('category/index', $data);
        }
		return view('auth/login');
	}

	public function store()
	{
		$this->configheader();
		$data_insert = $this->request->getPost();
		// echo '<pre>';
		// print_r($data_insert);
		// die;
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
		$id = $this->request->getPost()['id'];
		$subcategories = $this->subcategoryModel->getDataByid($id);
		if(!empty($subcategories)){
			foreach ($subcategories as $val_subcategory) {
				$this->subcategoryModel->destroy($val_subcategory['id']);
				$this->subcategoryProductModel->destroyByField('id_sub_category',$val_subcategory['id']);
			}
		}
		// echo '<pre>';
		// print_r($subcategories);
		// die;
		// echo $id;
		// die;
		$this->model->destroy($id);
		return $this->respond(['reponse'=>'Categoría desactivada correctamente.']);
	}

	public function getSelectb(){
		$query = $this->model->findAll();
		$query = $this->selectb->data($query)->make('id','name')->get();
		return $this->respond($query);
	}

	public function configheader(){
		return $this->response->setHeader('Access-Control-Allow-Origin', '*')
		->setHeader('Access-Control-Allow-Headers', '*')
		->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
	}
}

<?php

namespace App\Controllers;

use App\Libraries\DataTables;
use App\Libraries\ArrayQueries;
use CodeIgniter\RESTful\ResourceController;
use App\Models\SubCategoryProductModel;

class Products extends ResourceController
{
	protected $modelName = '\App\Models\ProductModel';
	protected $format    = 'json';
	private $datatables = null;
	private $array_query = null;
	private $subcategoryproduct = null;

	public function __construct()
	{
		$this->datatables = new DataTables();
		$this->array_query = new ArrayQueries();
		$this->subcategoryproduct = new SubCategoryProductModel();
	}

	public function index()
	{
		return view('product/index');
	}

	public function store()
	{
		$this->configheader();
		$data_insert = $this->request->getPost();
		// echo '<pre>';
		// print_r($data_insert);
		// die;
		$list_id_subcategories = explode(',',$data_insert['id_sub_category']);
        unset($data_insert['id_sub_category']);
		// echo ' insert id <pre> ';
		// print_r($list_id_subcategories);
		// die;
		$this->model->save($data_insert);
		$id_product = $this->model->getInsertID();
		// echo ' insert sub';
		foreach ($list_id_subcategories as $id_category) {
			$data_in['date'] = date("Y-m-d H:i:s"); 
			$data_in['id_sub_category'] = $id_category; 
			$data_in['id_product'] = $id_product; 
			$this->subcategoryproduct->save($data_in);
		}
		// die;
		return $this->respond(['reponse'=>'Producto creado correctamente.']);
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
		return $this->respond(['reponse'=>'Producto actualizado correctamente.']);
	}

	public function list()
	{
		$this->configheader();
		$data_query = $this->model->getAllItems(); 
		$data_transform = $this->array_query->data($data_query)->transform('id',['id_categoria','subcategorias'])->get();
		$data = $this->datatables->data($data_transform)->makeHeaders()->get();
		// echo '<pre> products';
		// print_r($data);
		// die;
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
		return $this->respond(['reponse'=>'Producto desactivado correctamente.']);
	}

	public function configheader(){
		return $this->response->setHeader('Access-Control-Allow-Origin', '*')
		->setHeader('Access-Control-Allow-Headers', '*')
		->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
	}
}

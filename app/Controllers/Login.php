<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;

class Login extends ResourceController
{
    protected $modelName = '\App\Models\ProductModel';
    protected $format    = 'json';
    protected $userModel = null;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        return view('auth/login');
    }

    public function checkLogin()
    {
        // echo '<pre>';
        $this->configheader();
        $credentials = $this->request->getPost();
        // print_r($credentials);
        // $hash = password_hash($credentials['password'], PASSWORD_DEFAULT);
        $password_hash_db = $this->getPassword($credentials['username']);
        if (password_verify($credentials['password'], $password_hash_db) && $password_hash_db) {
            echo 'Has iniciado sessión!';
        } else {
            echo 'Credenciales inválidas.';
        }
    }

    public function getPassword($user){
        // echo '<pre> get dataUser';
        // print_r($user);
        // die;
        $user_data = $this->userModel->where('username', $user)->first();
        print_r($user_data);
        return !empty($user_data['password'])?$user_data['password']:false;
    }

    public function store()
    {
        $this->configheader();
        $data_insert = $this->request->getPost();
    }

    public function updating()
    {
        $this->configheader();
        $data_update = $this->request->getPost();
        if (!empty($data_update['password'])) {
            $data_update['password'] = password_hash($data_update['password'], PASSWORD_DEFAULT);
        }
        $id = $data_update['id'];
        unset($data_update['id']);
        // echo '<pre>';
        // print_r($data_update);
        // echo ' id '.$id.' ';
        // die;
        $this->model->toUpdate($id, $data_update);
        return $this->respond(['reponse' => 'Producto actualizado correctamente.']);
    }

    public function destroy()
    {
        $this->configheader();
        // echo '<pre>';
        // print_r($id);
        // die;
        $id = $this->request->getPost()['id'];
        // echo $id;
        // die;
        $this->model->destroy($id);
        return $this->respond(['reponse' => 'Producto desactivado correctamente.']);
    }

    public function configheader()
    {
        return $this->response->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Headers', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
    }
}

<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use App\Controllers\SessionController;

class Login extends ResourceController
{
    protected $modelName = '\App\Models\ProductModel';
    protected $format    = 'json';
    protected $userModel = null;
    protected $session = null;
    protected $session_controller = null;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = session();
        $this->session_controller = new SessionController();
    }

    public function index()
    {
        if ($this->session_controller->hasSession()) {
            return view('user/index');
        }
        return view('auth/login');
    }

    public function checkLogin()
    {
        // echo '<pre>';
        $this->configheader();
        $credentials = $this->request->getPost();
        // print_r($credentials);
        // $hash = password_hash($credentials['password'], PASSWORD_DEFAULT);
        $data_user_db = $this->getPassword($credentials['username']);
        $password_hash_db = !empty($data_user_db['password']) ? $data_user_db['password'] : '';
        if (password_verify($credentials['password'], $password_hash_db) && $password_hash_db) {
            unset($data_user_db['password']);
            $this->setSession($data_user_db);
            return $this->respond(['response' => 'ok']);
        } else {
            return $this->respond(['response' => 'not']);
        }
    }

    public function destroySession()
    {
        $this->session->destroy();
        return view('auth/login');
    }

    public function getPassword($user)
    {
        // echo '<pre> get dataUser';
        // print_r($user);
        // die;
        $user_data = $this->userModel->where('username', $user)->where('state', 1)->first();
        // print_r($user_data);
        return !empty($user_data) ? $user_data : false;
    }

    public function setSession($data_session)
    {
        $this->session->set($data_session);
        // $this->session->get('username');
        // echo ' el usuario es ';
        // print_r($user);
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

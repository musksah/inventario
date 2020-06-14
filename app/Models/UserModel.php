<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'user';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id',
        'username',
        'rol',
        'password',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = false;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getAllItems()
    {
        return $this->db->table('user')
            ->select('user.id, user.username, user.rol, user.state')
            ->where('state', 1)
            ->get()
            ->getResultArray();
    }

    public function destroy($id)
    {
        return $this->builder()
            ->where('id',$id)
            ->set(['state' => 0])
            ->update();
    }

    public function toUpdate($id, $dataUpdate)
    {
        return $this->builder()
            ->where('id',$id)
            ->set($dataUpdate)
            ->update();
    }

    public function create($data)
    {
        return $this->builder()->insert($data);
    }

    public function empleadosSucursal()
    {
        return $this->db->table('sucursal')
            ->select('empleado.nombre, empleado.apellido, empleado.correo, sucursal.nombre AS `sucursal`')
            ->join('empleado', 'empleado.id_sucursal = sucursal.id_sucursal')
            ->get()
            ->getResultArray();
    }
}

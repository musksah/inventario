<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table      = 'category';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id',
        'name',
        'state',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = false;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getAllItems()
    {
        return $this->db->table('category')
            ->select('category.id, category.name, category.state')
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
}

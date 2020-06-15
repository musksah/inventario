<?php

namespace App\Models;

use CodeIgniter\Model;

class SubCategoryModel extends Model
{
    protected $table      = 'sub_category';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id',
        'name',
        'state',
        'quantity_products',
        'id_category',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = false;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getAllItems()
    {
        return $this->db->table('sub_category')
            ->select('sub_category.id, sub_category.name, sub_category.state, sub_category.quantity_products, sub_category.id_category')
            ->join('category', 'category.id = sub_category.id_category')
            ->where('sub_category.state', 1)
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

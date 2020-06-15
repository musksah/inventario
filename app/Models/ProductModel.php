<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'product';
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
        return $this->db->table('product')
            ->select('product.id, product.name, product.state')
            ->join('subcategory_product', 'subcategory_product.id_product = product.id')
            ->join('sub_category', 'sub_category.id = subcategory_product.id_sub_category')
            ->where('product.state', 1)
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
}

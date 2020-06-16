<?php

namespace App\Models;

use CodeIgniter\Model;

class SubCategoryProductModel extends Model
{
    protected $table      = 'subcategory_product';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id',
        'date',
        'id_sub_category',
        'id_product',
        'id_category',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = false;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

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
    
    public function destroyByField($field,$value){
		return $this->builder()
            ->where($field,$value)->delete();
	}

    public function create($data)
    {
        return $this->builder()->insert($data);
    }
}

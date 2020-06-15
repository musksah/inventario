<?php

namespace App\Libraries;

class SelectB
{
    protected $data = [];
    protected $headers = [];
    protected $select_options = [];

    public function data($data)
    {
        $this->data = $data;
        $this->table_object['data'] = $this->data;
        return $this;
    }

    public function make($col_value, $col_text)
    {
        $this->select_options[] = ['value' => null, 'text' => "Seleccionar..."];
        foreach ($this->data as $key => $value) {
            $this->select_options[] = ['value' => $value[$col_value], 'text' => $value[$col_text]];
        }
        return $this;
    }

    public function get()
    {
        // echo '<pre>';
        // print_r($this->select_options);
        // die;
        return $this->select_options;
    }
}

<?php

namespace App\Libraries;

class ArrayQueries
{
    private $data = null;
    private $group_field = [];
    private $fields_grouped = [];

    public function data($data)
    {
        $this->data = $data;
        return $this;
    }

    public function transform($group_field, array $fields_grouped)
    {
        // echo 'transform <pre> ';
        $list_item = [];
        // echo ' group_field ';
        $this->group_field = $group_field;
        // echo ' group_field ';
        $this->fields_grouped = $fields_grouped;
        // print_r($this->fields_grouped);
        // print_r($this->data);
        // die;
        foreach ($this->data as $key => $value) {
            if (in_array($value[$this->group_field], $list_item)) {
                $index = array_search($value[$this->group_field], $list_item);
                // echo ' lo encontró ';
                foreach ($fields_grouped as $val_f_grouped) {
                    // print_r($value[$val_f_grouped]);
                    // solución array
                    // $this->data[$index][$val_f_grouped]=$value[$val_f_grouped];
                    $this->data[$index][$val_f_grouped].=','.$value[$val_f_grouped];
                }
                unset($this->data[$key]);
            } else {
                // echo ' nada ';
                $list_item[$key] = $value[$this->group_field];
                foreach ($fields_grouped as $val_f_grouped) {
                    // print_r($value[$val_f_grouped]);
                    // $last_val = $this->data[$key][$val_f_grouped]; 
                    // $this->data[$key][$val_f_grouped].=','.$last_val;
                    //Solución Array
                    // $this->data[$key][$val_f_grouped]=[];
                    // $this->data[$key][$val_f_grouped][] = $last_val;
                }
            }
        }
        // echo '<pre> final';
        // print_r($this->data);
        // die;
        return $this;
    }

    public function get(){
        return $this->data;
    }
}

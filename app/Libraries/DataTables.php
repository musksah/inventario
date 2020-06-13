<?php

namespace App\Libraries;

class DataTables
{
    protected $data = [];
    protected $headers = [];
    protected $table_object;

    public function data($data)
    {
        $this->data = $data;
        $this->table_object['data'] = $this->data;
        return $this;
    }

    public function makeHeaders($columns = [])
    {
        if (!empty($this->data[0])) {
            foreach ($this->data[0] as $key => $value) {
                $this->headers[] = [$key];
            }
            $this->table_object['headers'] = $this->headers;
            return $this;
        } else {
            return $this;
        }
    }

    public function get()
    {
        return $this->table_object;
    }
}

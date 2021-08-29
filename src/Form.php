<?php

namespace Src\Form;

class Form{

    private $data = [];

    public function __construct($data = []){
            $this->data = $data;
    }

    public function input($name, $label = null, $type = 'text'){
        $label = $label ?? ucfirst($name);
        $value = $this->get($name);

        return "
        <label for='$name'>$label</label>
        <input type='.$type.' name='$name' class='form-control' value='$value'>
        ";

    }

    public function textArea($name, $label = null){
        $label = $label ?? ucfirst($name);
        $value = $this->get($name);
        return "
            <label for='$name'>$label</label>
            <textArea  name='$name' class='form-control' value='$value'></textArea>
        ";

    }

    public function select($name, $label = null, $options = []){
        $label = $label ?? ucfirst($name);
        $opt = '';
        foreach($options as $key => $option){
            $opt.= '<option value="'.$key.'">'.$option.'</option>';
        }

        return "
        <label for='$name'>$label</label>
            <select>
            $opt
            </select>
        ";
    }

    public function btnSubmit($name){
        return '<button>'.$name.'</button>';
    }

    public function get($key){
        return $this->data[$key] ?? null;
    }

    public function isSubmit(){
        return !empty($this->data);
    }

}
<?php


namespace App\Http\Controllers\Repository;


abstract class ClassBase
{
    public $nickName;
    public $name = 'ahiahi';

    public function create(){
        return $this->name;
    }
    public function update(){}
    public function delete(){}
}

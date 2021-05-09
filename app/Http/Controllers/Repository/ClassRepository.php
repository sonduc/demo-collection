<?php


namespace App\Http\Controllers\Repository;


class ClassRepository extends ClassBase implements ClassInterface
{

    public function create()
    {
//        $this->name = 'olala';
        return parent::create();
    }
}

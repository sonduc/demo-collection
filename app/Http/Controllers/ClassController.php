<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Repository\ClassInterface;
use App\Http\Controllers\Repository\ClassRepository;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function create()
    {
        $repo = new ClassRepository();
        $result = $repo->create();
        dd($result);
    }
}

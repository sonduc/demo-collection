<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        Cache::set('todo', $todos);
        dd(Cache::get('todo'));
        return response()->json($todos);
    }
}

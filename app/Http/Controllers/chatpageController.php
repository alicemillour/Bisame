<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class chatpageController extends Controller
{
     public function index()
    {
        return view('chatpage');
    }
}

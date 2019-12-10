<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubmitController extends Controller
{
    public function create(){

    	return view('form');
    }

    public function store(){

    }
}

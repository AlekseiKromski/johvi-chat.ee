<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{

    private $custom_css = null;

    public function index(){
        $custom_css = $this->custom_css;
        return view('login', compact('custom_css'));
    }

    public function register(){
        $custom_css = $this->custom_css = 'register';
        return view('register', compact('custom_css'));
    }

}

<?php

namespace App\Http\Controllers\AdminUtama;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
   public function showLoginForm(){
    return view('Auth/login');
   }
}

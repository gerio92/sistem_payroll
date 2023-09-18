<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class RegisterController extends Controller
{
    public function index()
{
   return view('register.index', [
         'title' =>'Register', 
        ]);
}

    public function store(Request $request)
    {
       $validatedData = $request->validate([
            'username' => ['required', 'min:3', 'max:25', 'unique:users'],
            'password' => 'required|min:5|max:25'
       ]);

       $validatedData['password'] = bcrypt($validatedData['password']);

       User::create($validatedData);
    //    $request->session()->flash
       return redirect('/login')->with('success', 'Registrasi Berhasil Silahkan Login');
    }
}

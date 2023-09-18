<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function index()
{
   return view('login.index', [
         'title' =>'Login', 
        ]);
}
public function admin()
{
    // Ambil data user dengan kolom username dan level
    $users = User::select('id', 'username', 'level')->get();

    // Tampilkan view dengan data users
    return view('user.index', compact('users'));
}

public function edit($id)
{
    $user = User::findOrFail($id);
    return view('user.edit', ['user' => $user]);
}

public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    // Validasi input
    $request->validate([
        'username' => 'required|string|max:255',
        'level' => 'required|string|max:255',
    ]);

    // Update data user
    $user->update([
        'username' => $request->username,
        'level' => $request->level,
    ]);

    return redirect()->route('user.admin')->with('success', 'Data admin berhasil diperbarui.');
}




    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('karyawan');
        }

        return back()->with('loginError', 'Login Gagal!');
        // dd('berhasil');
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    }
}

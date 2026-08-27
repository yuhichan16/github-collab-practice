<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(20);
        return view('users.index', ['users' => $users]);
    }

    public function store(Request $request)
    {

        /*  この部分をvalidate化とpasswordをhash化した
        --  消すよりもコメントアウトしとくと後でわかりやすいかも
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        */

        $validated = $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|emall|unique:users',
            'password' => 'required|min:8',
        ]);

        Uesr::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);


        return redirect('/users');
    }
}

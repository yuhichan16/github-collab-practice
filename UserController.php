<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        //all()は全件取得、パフォーマンス向上のためにpaginate(20)で絞る
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

        // $validated = を使用してセキュリティ向上
        $validated = $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|emall|unique:users',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            // パスワードをhash化してセキュリティ向上
        ]);

        /*User::create([])は
        new User + save()という作成と保存の
        2つの意味を持つからコードの簡略化が可能
        */


        return redirect('/users');
    }
}

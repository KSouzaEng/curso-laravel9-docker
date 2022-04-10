<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\FormUpdateCreateRequest;

class UserController extends Controller
{
    public function index(Request $request){

        $search = $request->search;

        $users = User::where(function($query) use ($search){

            if($search){
            $query->where('email',$search);
            $query->orwhere("name","LIKE","%{$search}%");
            }
        })->get();
        // $users = User::where()->get();

     return view('users.index',compact('users'));
    }

    public function show($id){

        // $user = User::where('id',$id)->first();
        $user = User::find($id);

        if(!$user){
            return redirect()->route('users.index');
        }else{
            return view('users.show',compact('user'));
        }

    }
    public function create(){

        return view('users.create');
    }
    public function store(FormUpdateCreateRequest $request){

            $user = User::create([

                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            return redirect()->route('users.index');

    }

    public function edit($id){

        $user = User::find($id);

        if(!$user){
            return redirect()->route('users.index');
        }else{
            return view('users.edit',compact('user'));
        }
    }

    public function update(Request $request,$id){

        $user = User::find($id);

        if(!$user){
            return redirect()->route('users.index');
        }else{
            $user = User::where('id',$id)->update([

                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            return redirect()->route('users.index');

        }
    }
}

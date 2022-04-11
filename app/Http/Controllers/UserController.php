<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\FormUpdateCreateRequest;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function index(Request $request){

        $search = $request->search;

        $users = User::where(function($query) use ($search){

            if($search){
            $query->where('email',$search);
            $query->orwhere("name","LIKE","%{$search}%");
            }
        })
        ->with('comments')
        ->paginate(1);
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

        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        if ($request->image) {
            $data['image'] = $request->image->store('users');
            // $extension = $request->image->getClientOriginalExtension();
            // $data['image'] = $request->image->storeAs('users', now() . ".{$extension}");
        }

        $this->model->create($data);

        // return redirect()->route('users.show', $user->id);
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

    public function update(FormUpdateCreateRequest $request, $id)
    {
        if (!$user = $this->model->find($id))
            return redirect()->route('users.index');

        $data = $request->only('name', 'email');
        if ($request->password)
            $data['password'] = bcrypt($request->password);

        if ($request->image) {
            if ($user->image && Storage::exists($user->image)) {
                Storage::delete($user->image);
            }

            $data['image'] = $request->image->store('users');
        }

        $user->update($data);

        return redirect()->route('users.index');
    }

}

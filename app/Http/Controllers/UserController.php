<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Access\Gate;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request,$next){
            if(Gate::allows('manage-users')) return $next($request);
            abort(403,'Anda tidak memiliki cukup hak akses');
        });
    }

    public function index(Request $request)
    {
        $users = User::paginate(2);
        $filterKeyword = $request->get('keyword');
        $status = $request->get('status');
        if($status){
            $users = User::where('status', $status)->paginate(2);
        } else {
            $users = User::paginate(2);
        }

        if($filterKeyword)
        {
            if($status)
            {
                $users = User::where('email', 'LIKE', "%$filterKeyword%") ->where('status', $status)->paginate(2);
            }else
            {
                $users = User::where('email', 'LIKE', "%$filterKeyword%")->paginate(2);
            }
        }
        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Validator::make($request->all(),[
            "name" => "required|min:5|max:100",
            "username" => "required|min:5|max:20",
            "roles" => "required",
            "phone" => "required|digits_between:10,12",
            "address" => "required|min:20|max:200",
            "avatar" => "required",
            "email" => "required|email",
            "password" => "required",
            "password_confirmation" => "required|same:password"
        ])->validate();
        //buat instance dari model user
        $user = new User();
        //masukkan list yang ingin dimasukkan datanya
        $user->name = $request->get('name');
        $user->username = $request->get('username');
        $user->roles = json_encode($request->get('roles'));
        $user->name = $request->get('name');
        $user->address = $request->get('address');
        $user->phone = $request->get('phone');
        $user->email = $request->get('email');
        $user->password = \Hash::make($request->get('password'));
        //untuk handle data sebuah file
        if($request->file('avatar')){
            $file = $request->file('avatar')->store('avatars','public');
            $user->avatar = $file;
        }
        //simpan data menggunakan fungsi/helper save()
        $user->save();
        //masukkan nilai balik dari method store
        return redirect()->route('users.index')->with('status', 'User successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::findOrFail($id);
        return view('users.edit', compact('users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $users = User::findOrFail($id);
        \Validator::make($request->all(), [
            "name" => "required|min:5|max:100",
            "roles" => "required",
            "phone" => "required|digits_between:10,12",
            "address" => "required|min:20|max:200",
        ])->validate();
        $users->name = $request->get('name');
        $users->roles = json_encode($request->get('roles'));
        $users->address = $request->get('address');
        $users->phone = $request->get('phone');
        if($users->avatar && file_exists(storage_path('app/public/'.$users->avatar)))
        {
            if($users->avatar && file_exists(storage_path('app/public/' . $users->avatar))){
                Storage::delete('public/'.$users->avatar);
            }
            $file = $request->file('avatar')->store('avatars', 'public');
            $users->avatar = $file;
        }
        $users->save();
        //return $users;
        return redirect()->route('users.index',$users->id)->with('status','User berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users = User::findOrFail($id);
        $users->delete();
        return redirect()->route('users.index')->with('status','User Berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Mail\ValidatorEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
  
    public function index()
    { 
       return response()->json(["msg"=>"Users finded",
        "data: "=>User::all(),],200);
    }
    public function store(Request $request)
    {
       
        $validate = Validator::make(
            $request->all(),[
                "name"=>"required|max:30",
                "email"=>"required|unique:users|email",
                "rol_id"=>"numeric|between:1,3",
                "password"=>"required|min:8|string"
            ]
        );

        if($validate->fails())
        {
            return response()->json(["msg"=>"Data failed",
            "data:"=>$validate->errors()],422);
        }

        $user = new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->rol_id=$request->get('rol_id',3);
        $user->save();
        $signedroute = URL::temporarySignedRoute(
            'activate',
            now()->addMinutes(10),
            ['user' => $user->id]
        );
        Mail::to($request->email)->send(new ValidatorEmail($signedroute));
        return response()->json(["msg"=>"User created, check your email","data"=>$user,],201);
    }

    public function update(Request $request,int $id)
    {
        $validate = Validator::make(
            $request->all(),[
                "name"=>"required|max:30",
                "email"=>"unique:users|email",
                "rol_id"=>"numeric|between:1,3",
                "password"=>"min:8|string"
            ]
        );

        if($validate->fails())
        {
            return response()->json(["msg"=>"Data failed",
            "data:"=>$validate->errors()],422);
        }
        $user=User::find($id);
        if($user)
        {
            $user->name=$request->get('name',$user->name);
            $user->email=$request->get('email',$user->email);
            $user->password=$request->get('password',$user->password);
            $user->rol_id=$request->get('rol_id',$user->rol_id);
            $user->save();
            return response()->json(["msg"=>"User updated","data"=>$user,],202);
        }
        return response()->json([
            "msg"   =>"Userd not found"
        ],404);
        
    }

    public function destroy(int $id)
    {
        $user=User::find($id);
        if($user){
            $user->delete();
            return response()->json(["msg"=>"User eliminado","data"=>$user,],202);
        }
        return response()->json([
            "msg"   =>"User not found"
        ],404);
    }

    public function activate(User $user)
    {
        $user->is_active=true;
        $user->save();
        
      
    }
}

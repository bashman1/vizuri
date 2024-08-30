<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{


    public function createUser(Request $request){
        try {
            DB::beginTransaction();
            $user = User::create([
                "name" => $request->first_name.' '.$request->last_name.' '.$request->other_names,
                "email"=> $request->email,
                "password"=>Hash::make($request->password),
                "uuid"=> $this->generateUuid(),
                "first_name"=> $request->first_name,
                "last_name"=>$request->last_name,
                "other_names"=> $request->other_names,
                "user_type_id"=>  $request->user_type_id,
                "company_id" => $request->company_id,
                "branch_id"=> $request->branch_id,
                "status"=>'Active',
                "created_on"=> Carbon::now(),
                "created_by"=>1,
            ]);
            DB::commit();
            return $this->genericResponse(true, "User created successfully", 201, $user);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }
    }

    public function login(Request $request){
        try {
            $validateUser = validator::make($request->all(),
            [
                'email'=>'required|email',
                'password'=>'required'
            ]);

            if($validateUser->fails()){
                return $this->genericResponse(false, $validateUser->errors(), 401, []);
            }

            if(!auth()->attempt($request->only(["email", "password"]))){
                return $this->genericResponse(false, "Invalid email or password", 401, []);
            }

            $user = User::where("email", $request->email)->first();

            $token = $user->createToken("API TOKEN")->plainTextToken;
            return $this->genericResponse(true, "User logged in successfully", 200, ["token"=>$token, "user"=>$user]);

        } catch (\Throwable $th) {
            return $this->genericResponse(false, $th->getMessage(), 500, $th);
        }

    }

}

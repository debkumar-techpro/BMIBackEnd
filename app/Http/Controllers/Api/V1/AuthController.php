<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{

    public function __construct()
    {
        $this->middleware('api.auth', ['except' => ['login', 'register','register_test']]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'name' => 'required|between:3,15',
            'email' => 'required|email|unique:users|max:255',
            /*'password' => 'required|string|min:4'*/
        ]);
        if ($validator->fails()) {
            return $this->errorValidator(40001, $validator);
        }
        $user = new User();
        /*$user->name = $request->input('name');*/
        $user->email = $request->input('email');
        /*$user->password = (new BcryptHasher)->make($request->input('password'));*/
        $user->password = (new BcryptHasher)->make('123456');
        $user->save();
        $token = Auth::guard('api')->fromUser($user);
        return $this->respondWithToken($token);
    }

    public function register_test(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|between:3,15',
            'email'    => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:4',
        ]);
        if ($validator->fails()) {
            return $this->errorValidator(40001, $validator);
        }
        /**/
        $objDemo           = new \stdClass();
        $objDemo->demo_one = 'Demo One Value';
        $objDemo->demo_two = 'Demo Two Value';
        $objDemo->sender   = 'SenderUserName';
        $objDemo->receiver = 'ReceiverUserName';

        //Mail::to("debkumar.daschakraborty@techprostudio.com")->send(new DemoEmail($objDemo));
        return response()->json(Mail::to("debkumar.daschakraborty@techprostudio.com")->send(new DemoEmail($objDemo)));
        exit();
        /**/
        $user           = new User();
        $user->name     = $request->input('name');
        $user->email    = $request->input('email');
        $user->password = (new BcryptHasher)->make($request->input('password'));
        $user->save();
        $token = Auth::guard('api')->fromUser($user);
        return $this->respondWithToken($token);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->errorValidator(40001, $validator);
        }
        $credentials = $request->only('email', 'password');
        if (!$token = Auth::guard('api')->setTTL(72000)->attempt($credentials)) {
            return response()->json(['errcode' => 40001, 'errmsg' => 'Unauthorized.'], 401);
        }
        return $this->respondWithToken($token);
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return response(['message' => 'You sucessfuly logout']);
    }

    public function refresh()
    {
        $token = Auth::guard('api')->refresh();
        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

    public function getCurrentToken()
    {
        $token = Auth::guard('api')->getToken()->get();
        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }
}
<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\ResponseUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function register()
    {
        $this->request->validate([
            'age' => ['integer'],
            'role_id' => ['integer'],
        ]);

        $request = $this->request;

        if (!$request['name']) {
            return ResponseUtil::error('Nama tidak boleh kosong', 400);
        }

        if (!$request['phone']) {
            return ResponseUtil::error('Nomor tidak boleh kosong', 400);
        }

        if (!$request['password']) {
            return ResponseUtil::error('Password tidak boleh kosong', 400);
        }

        if (!$request['age']) {
            return ResponseUtil::error('Usia tidak boleh kosong', 400);
        }

        if (!$request['blood_type']) {
            return ResponseUtil::error('Golongan darah tidak boleh kosong', 400);
        }

        $request = $request->only(['name', 'phone', 'password', 'image', 'age', 'blood_type']);



        $user = User::where('phone', '=', trim($request['phone']))->first();
        if ($user) {
            return ResponseUtil::error('User sudah ditambahkan', 400);
        }


        $request['role_id'] = 1;
        $request['isPendonor'] = false;
        $request['password'] = bcrypt($request['password']);

        $userResponse = User::create($request);

        $token = $userResponse->createToken('auth_token')->plainTextToken;
        $userResponse['access_token'] = $token;

        return ResponseUtil::success($userResponse);
    }

    public function login()

    {

        $request = $this->request;

        if (!$request['phone']) {
            return ResponseUtil::error('Phone tidak boleh kosong', 400);
        }

        if (!$request['password']) {
            return ResponseUtil::error('password tidak boleh kosong', 400);
        }

        $request = $request->only(['phone', 'password']);

        $user = User::where('phone', '=', trim($request['phone']))->first();
        if (!$user) {
            return ResponseUtil::error('Nomor tidak ditemukan', 400);
        }


        if (Auth::attempt($request, false)) {
            $token = $user->createToken('auth_token')->plainTextToken;
            $user['access_token'] = $token;
           
            return ResponseUtil::success($user);
        }

        return ResponseUtil::error('Password Salah', 400);
    }

}

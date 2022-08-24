<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\ResponseUtil;
use Illuminate\Http\Request;

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
        $data = [
            'id' => $userResponse->id,
            'name' => $userResponse->name,
            'phone' => $userResponse->email,
            'role_id' => $userResponse->role_id,
            'nip' => $userResponse->nip,
            'access_token' => $token
        ];

        return ResponseUtil::success($data);
    }

}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ResetPassword;
use App\Models\User;
use App\Utils\HelperUtil;
use App\Utils\ResponseUtil;
use Carbon\Carbon;
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

        $request = $request->only(['name', 'phone', 'password', 'image', 'age', 'blood_type', 'token_fcm']);



        $user = User::where('phone', '=', trim($request['phone']))->first();
        if ($user) {
            return ResponseUtil::error('User sudah ditambahkan', 400);
        }


        $request['role_id'] = 1;
        $request['is_pendonor'] = true;
        $request['password'] = bcrypt($request['password']);

        $userResponse = User::create($request)->fresh();

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

        if ($this->request['token_fcm']) {
            $user->update(['token_fcm' => $this->request['token_fcm']]);
        }

        if (Auth::attempt($request, false)) {
            $token = $user->createToken('auth_token')->plainTextToken;
            $user['access_token'] = $token;

            return ResponseUtil::success($user);
        }

        return ResponseUtil::error('Password Salah', 400);
    }

    public function setAdmin($userId)
    {

        $user = User::find($userId);

        if (!$user) {
            return ResponseUtil::error('User tidak ditemukan', 400);
        }
        $user->role_id = 2;
        $user->save();
        return ResponseUtil::success($user);
    }

    public function requestReset()

    {

        if (!$this->request['phone']) {
            return ResponseUtil::error('Nomor tidak boleh kosong', 400);
        }

        $user = USer::where('phone', '=', trim($this->request->phone))->first();

        if (!$user) {
            return ResponseUtil::error('Nomor tidak ditemukan', 400);
        }
        $token  = HelperUtil::randomChar(32);

        $payloads   = [
            'token' => $token,
            'user_id' => $user->id,
        ];

        $passwordReset  = ResetPassword::where('user_id', '=', $user->id)->first();
        
        if (!$passwordReset) {
            $passwordReset  = ResetPassword::create($payloads);
        }
        $expiredAt  = Carbon::now()->addHours(3)->format("Y-m-d H:i:s");

        $result = ['token_reset_password' => $passwordReset->token, 'phone' => $this->request->phone, 'expired_at' => $expiredAt];

        return ResponseUtil::success($result);
    }

    public function reset()
    {


        $this->validate($this->request, [
            'password' => ['required', 'min:8'],
            'token' => ['required'],
        ]);

        $token  = $this->request->token;
        $passwordReset  = ResetPassword::where('token', '=', $token)->first();
        if (!$passwordReset) {
            return ResponseUtil::error('token tidak ditemukan', 404);
        }



        $user   = User::find($passwordReset->user_id);

        $user->update([
            'password' => bcrypt($this->request->password),
        ]);

        ResetPassword::where('user_id', '=', $user->id)->delete();

        return ResponseUtil::success('Berhasil reset password');
    }


    public function logout()
    {
        $auth = Auth::user();
        $user = User::find($auth->id);

        $user->update(['token_fcm' => null]);
        return ResponseUtil::success($user);
    }
}

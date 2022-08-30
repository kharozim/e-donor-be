<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Models\User;
use App\Utils\ResponseUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function me()
    {
        $user = Auth::user();
        return ResponseUtil::success($user);
    }

    public function updateMe()
    {
        $auth = Auth::user();
        $user = User::find($auth->id);

        $request = $this->request;
        $request = $request->only(['name', 'phone', 'image', 'age', 'blood_type', 'token_fcm']);

        $user->update($request);
        return ResponseUtil::success($user);
    }

    public function all()
    {
        $auth = Auth::user();
        if ($auth->role_id != 2) {
            return ResponseUtil::error('Akses ditolak. Anda bukan admin!', 400);
        }

        $result = User::get();

        return ResponseUtil::success($result);
    }


    public function detail($userId)
    {
        $auth = Auth::user();
        if ($auth->role_id != 2) {
            return ResponseUtil::error('Akses ditolak. Anda bukan admin!', 400);
        }

        $user = User::find($userId);
        if (!$user) {
            return ResponseUtil::error('User tidak ditemukan', 400);
        }

        return ResponseUtil::success($user);
    }

    public function update($userId)
    {
        $auth = Auth::user();
        $user = User::find($userId);

        if ($auth->role_id != 2) {
            return ResponseUtil::error('Akses ditolak. Anda bukan admin!', 400);
        }

        if (!$user) {
            return ResponseUtil::error('User tidak ditemukan', 400);
        }
        $request = $this->request;
        $request = $request->only(['name', 'phone', 'image', 'is_pendonor', 'age', 'blood_type', 'token_fcm']);

        $user->update($request);
        return ResponseUtil::success($user);
    }

    public function delete($userId)
    {
        $auth = Auth::user();
        $user = User::find($userId);

        if ($auth->role_id != 2) {
            return ResponseUtil::error('Akses ditolak. Anda bukan admin!', 400);
        }
        if (!$user) {
            return ResponseUtil::error('User tidak ditemukan', 400);
        }

        if ($user->id == $auth->id) {
            return ResponseUtil::error('Tidak dapat menghapus diri sendiri', 403);
        }

        if ($user->is_pendonor) {
            $pendonor = Donor::where('user_id', '=', $user->id)->first();

            if ($pendonor) {
                $pendonor->delete();
            }
        }

        $user->delete();
        return ResponseUtil::success("Berhasil hapus User");
    }
}

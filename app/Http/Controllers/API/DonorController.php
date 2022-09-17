<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Models\User;
use App\Utils\ResponseUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonorController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function all()
    {
        $user = Auth::user();

        if ($user->role_id != 2) {
            return ResponseUtil::error('Akses ditolak. Anda bukan admin', 400);
        }

        $result = Donor::get()->all();
        return ResponseUtil::success($result);
    }

    public function allRequest()
    {
        $user = Auth::user();

        if ($user->role_id != 2) {
            return ResponseUtil::error('Akses ditolak. Anda bukan admin', 400);
        }

        $result = Donor::where('status', '=', 0)->get();
        return ResponseUtil::success($result);
    }

    public function myDonor()
    {
        $user = Auth::user();

        $donor = Donor::where('user_id', '=', $user->id)->first();
        if (!$donor) {
            return ResponseUtil::error('Anda belum mendaftar', 400);
        }

        return ResponseUtil::success($donor);
    }

    public function detail($donorId)
    {
        $user = Auth::user();

        if ($user->role_id != 2) {
            return ResponseUtil::error('Akses ditolak. Anda bukan admin', 400);
        }

        $donor = Donor::where('id', '=', $donorId)->first();
        if (!$donor) {
            return ResponseUtil::error('Donor tidak ditemukan', 400);
        }

        return ResponseUtil::success($donor);
    }

    public function addRequest()
    {
        $user = Auth::user();

        $donor = Donor::where('user_id', '=', $user->id)->first();
        if ($donor) {
            if ($donor->status != -1) {
                return ResponseUtil::error('Anda sudah mendaftar', 400);
            }
        }

        $request = $this->request;
        if (!$request['nik']) {
            return ResponseUtil::error('NIK tidak boleh kosong', 400);
        }

        if (!$request['phone']) {
            return ResponseUtil::error('Nomor telepon (WA) tidak boleh kosong', 400);
        }

        if (!$request['ttl']) {
            return ResponseUtil::error('Tempat tanggal lahir tidak boleh kosong', 400);
        }

        if (!$request['address']) {
            return ResponseUtil::error('Alamat tidak boleh kosong', 400);
        }

        if (!$request['city']) {
            return ResponseUtil::error('Kota tidak boleh kosong', 400);
        }

        $request->validate([
            'nik' => 'integer'
        ]);
        $request = $request->only(['nik', 'phone', 'ttl', 'address', 'city']);

        $request['status'] = 0;
        $request['user_id'] = $user->id;

        $result = Donor::create($request);
        return ResponseUtil::success($result);
    }

    public function confirmation($donorId)
    {
        $auth = Auth::user();
        if ($auth->role_id != 2) {
            return ResponseUtil::error('Akses ditolak. Anda bukan admin', 400);
        }


        $request = $this->request;
        if ($request['status'] != 1 && $request['status'] != -1) {
            return ResponseUtil::error('Status tidak valid. status yang di perbolehkan, 1 atau -1', 400);
        }

        $request->validate([
            'status' => 'integer'
        ]);


        $donor = Donor::find($donorId);
        if (!$donor) {
            return ResponseUtil::error('Donor tidak ditemukan', 400);
        }

        $user = User::find($donor->user_id);

        $request = $request->only(['status']);

        if ($request['status'] == 1) {
            $user->update(['is_pendonor' => true]);
        } else {
            $user->update(['is_pendonor' => false]);
        }

        $donor->update($request);

        return ResponseUtil::success($donor);
    }

    // public function update($donorId)
    // {
    //     $user = Auth::user();
    //     $donor = Donor::find($donorId);
    //     if (!$donor) {
    //         return ResponseUtil::error('Donor tidak ditemukan', 400);
    //     }

    //     $request = $this->request;
    //     $request->validate([
    //         'phone' => 'integer',
    //         'nik' => 'integer'
    //     ]);

    //     $donor->update($request);
    //     return ResponseUtil::success($donor);
    // }


    public function delete($donorId)
    {
        $user = Auth::user();
        if ($user->role_id != 2) {
            return ResponseUtil::error('Akses ditolak. Anda bukan admin', 400);
        }
        $donor = Donor::find($donorId);
        if (!$donor) {
            return ResponseUtil::error('Donor tidak ditemukan', 400);
        }

        $donor->delete();
        return ResponseUtil::success('Berhasil hapus data');
    }
}

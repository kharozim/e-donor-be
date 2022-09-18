<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Information;
use App\Utils\ResponseUtil;
use App\Utils\UploadUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformationController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function all()
    {
        $user = Auth::user();

        $result = Information::get()->all();
        return ResponseUtil::success($result);
    }

    public function detail($informationId)
    {
        $user = Auth::user();

        $result = Information::find($informationId);

        if (!$result) {
            return ResponseUtil::error('Data tidak ditemukan', 400);
        }

        return ResponseUtil::success($result);
    }


    public function add()
    {
        $user = Auth::user();

        if ($user->role_id != 2) {
            return ResponseUtil::error('Akses ditolak. Anda bukan admin', 400);
        }

        $request = $this->request;

        if (!$request['title']) {
            return ResponseUtil::error('Judul tidak boleh kosong', 400);
        }

        if (!$request['description']) {
            return ResponseUtil::error('Deskripsi tidak boleh kosong', 400);
        }

        if (!$request['date']) {
            return ResponseUtil::error('Tanggal tidak boleh kosong', 400);
        }

        if (!$request['image']) {
            return ResponseUtil::error('Gambar tidak boleh kosong', 400);
        }



        $request = $request->only(['title', 'description', 'image', 'date']);


        if ($this->request->hasFile('image')) {
            $file = $this->request->file('image');
            $attachment = UploadUtil::upload('information', $file);
            // $request['image'] = url($attachment);
            $request['image'] = $attachment;
        }

        $result = Information::create($request);
        return ResponseUtil::success($result);
    }


    public function update($informationId)
    {
        $user = Auth::user();

        if ($user->role_id != 2) {
            return ResponseUtil::error('Akses ditolak. Anda bukan admin', 400);
        }

        $info = Information::where('id', '=', $informationId)->first();

        if (!$info) {
            return ResponseUtil::error('Data tidak ditemukan', 404);
        }


        $request = $this->request->only(['title', 'description', 'image', 'date']);

        if ($this->request->hasFile('image')) {
            $file = $this->request->file('image');
            $attachment = UploadUtil::upload('information', $file);
            // $request['image'] = url($attachment);
            $request['image'] = $attachment;
        }

        $info->update($request);

        return ResponseUtil::success($info);
    }

    public function delete($informationId){

        $user = Auth::user();

        if ($user->role_id != 2) {
            return ResponseUtil::error('Akses ditolak. Anda bukan admin', 400);
        }

        $info = Information::where('id', '=', $informationId)->first();

        if (!$info) {
            return ResponseUtil::error('Data tidak ditemukan', 404);
        }

        $info->delete();
        return ResponseUtil::success('Berhasil hapus data');
        
    }

}

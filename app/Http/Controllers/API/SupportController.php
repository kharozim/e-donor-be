<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Models\Support;
use App\Models\User;
use App\Utils\FirebaseUtil;
use App\Utils\ResponseUtil;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
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

        $result = Support::get()->sortDesc()->values()->all();
        return ResponseUtil::success($result);
    }


    public function allTakeByMe()
    {
        $user = Auth::user();

        $result = Support::where([
            ['take_by', '=', $user->id],
            ['status', '!=', 0]
        ])->get()->sortDesc()->values()->all();
        return ResponseUtil::success($result);
    }

    public function allRequest()
    {

        $user = Auth::user();

        $result = Support::where('status', '=', 0)->get()->sortDesc()->values()->all();
        if (count($result) > 0) {
            $now = Carbon::now('Asia/Jakarta')->toDateTimeString();
            $count = 0;

            for ($i = 0; $i <= count($result) - 1; $i++) {
                $new = Carbon::createFromFormat('Y-m-d H:i:s',  $result[$i]->expired_at, 'Asia/Jakarta')->toDateTimeString();
                if ($now > $new) {
                    $result[$i]->update(['status' => -1]);
                    $count += 1;
                }
            }

            if ($count > 0) {
                $result = Support::where('status', '=', 0)->get()->sortDesc()->values()->all();
            }
        }
        return ResponseUtil::success($result);
    }


    public function detail($supportId)
    {

        $user = Auth::user();

        $result = Support::find($supportId);
        if (!$result) {
            return ResponseUtil::error('Bantuan tidak ditemukan', 400);
        }
        return ResponseUtil::success($result);
    }

    public function add()
    {
        $user = Auth::user();

        $users = User::where([
            ['is_pendonor', '=', true],
            ['role_id', '=', 1],
            ['id', '!=', $user->id]
        ])
            ->whereNotNull('token_fcm')
            ->get();


        $request = $this->request;

        if (!$request['address']) {
            return ResponseUtil::error('Alamat tidak boleh kosong', 400);
        }

        if (!$request['blood_type_request']) {
            return ResponseUtil::error('Golongan darah tidak boleh kosong', 400);
        }

        $request = $request->only(['blood_type_request', 'address']);
        $request['user_id'] = $user->id;
        $request['status'] = 0;

        $expiredAt = Carbon::now('Asia/Jakarta')->addMinutes(15)->toDateTimeString();
        $request['expired_at'] = $expiredAt;

        $result = Support::create($request);

        foreach ($users as $item) {
            $notification = [
                'title' => 'Relawan donor darah dibutuhkan!',
                'body' => 'Bpk / Ibu ' . $result->user->name . ' sedang membutuhkan bantuan donor darah : ' . $result->blood_type_request,
                'type' => 'support',
                'user_id' => $result->user_id
            ];
            FirebaseUtil::sendToFcm($item->token_fcm, $notification);
            NotificationController::add($notification);
        }

        return ResponseUtil::success($result);
    }

    public function take($supportId)
    {
        $user = Auth::user();
        $support = Support::find($supportId);
        $donor = Donor::where('user_id', '=', $user->id)->first();

        if (!$user->is_pendonor) {
            return ResponseUtil::error('Anda bukan pendonor aktif, silahkan hubungi admin', 400);
        }

        if (!$support) {
            return ResponseUtil::error('Bantuan tidak ditemukan', 400);
        }

        if (!$donor) {
            return ResponseUtil::error('Anda belum terdaftar jadi pendonor, Silahkan mendaftar terlebih dahulu.', 400);
        }

        if ($support->status != 0) {
            return ResponseUtil::error('Bantuan telah ditutup', 400);
        }

        if ($support->user_id == $user->id) {
            return ResponseUtil::error('Tidak dapat mengambil bantuan anda sendiri', 400);
        }

        if ($support->blood_type_request != $user->blood_type) {
            return ResponseUtil::error('Golongan darah tidak sesuai', 403);
        }


        $support->update(['status' => 1, 'take_by' => $user->id]);
        $user = User::find($user->id);
        $user->update(['history_donor_count' => $user->history_donor_count + 1, 'is_pendonor' => false]);

        $notification = [
            'title' => 'Selamat permintaan donor telah di ambil oleh ' . $user->name,
            'body' => 'donor akan segera dikirim',
            'type' => 'home',
            'user_id' => $support->user_id
        ];


        try {
            if ($support->user->token_fcm) {
                FirebaseUtil::sendToFcm($support->user->token_fcm, $notification);
            }
        } catch (Exception $e) {
            // throw $e;
        }

        NotificationController::add($notification);

        return ResponseUtil::success($support);
    }
}

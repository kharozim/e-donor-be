<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
}

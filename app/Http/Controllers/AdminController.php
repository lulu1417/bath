<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends BaseController
{
    function index()
    {

        try {
            $users = User::where('isIn', 1)->get();
            $result = $users->toArray();
            return $this->sendResponse($result, 200);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function kick(Request $request)
    {
        Log::info($request->input());
        try {
            $user = User::find($request['user_id']);
            $user->update(['isIn' => 0]);
            $result = $user->toArray();
            return $this->sendResponse($result, 200);
        }catch (Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }
}

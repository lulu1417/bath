<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AdminController extends BaseController
{
    function index()
    {
        try {
            $result = User::all();
            return $this->sendResponse($result, 200);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 400);
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
        try {
            $user = User::find($request['id'])->get()->first();
            $user->update(['isIn' => 0]);
            $result = $user->toArray();
            return $this->sendResponse($result, 200);
        }catch (Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }
}

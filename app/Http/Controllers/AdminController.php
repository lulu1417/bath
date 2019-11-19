<?php

namespace App\Http\Controllers;
use App\User;
use App\Admin;
use App\Drink;
use Illuminate\Http\Request;

class AdminController extends BaseController
{
    function userList()
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function kick(Request $request)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Admin;
use App\Drink;

class ShowerController extends BaseController
{

    function drink()
    {
        try {
            $result = Drink::all();
            return $this->sendResponse($result, 200);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }

    function buy(Request $request)
    {
        try {
            $user = new User;
            $user = $user->getUser($request['name']);
            $money = $user->getMoney($request['name']);
            $drink = new Drink;
            $drink_id = $drink->getID($request['m_id']);
            $drink_name = $drink->getDrinkName($request['m_id']);
            $drink_price = $drink->getPrice($drink_id);
            $money -= $drink_price;
            if ($money > 0) {
                $user->update(['money' => $money, 'drink' => $drink_name]);
                $result = $user->toArray();
                    return $this->sendResponse($result, 200);
            } else {
                return $this->sendError("Your money is not enough.", 400);
            }
        } catch (Exception $error) {

            return $this->sendError("Drink item not found.", 400);
        }
    }

    function login(Request $request)
    {
        try {
            $user = new User;
            $user = $user->getUser($request['name']);
            if ($user) {
                $user = $user->toArray();;
                return $this->sendResponse($user, 200);
            } else {
                $request->validate([
                    'name' => ['required', 'string', 'unique:users'],
                ]);
                $create = User::create([
                    'name' => $request['name'],
                    'money' => 2000,
                    'drink' => null,
                    'isIn' => 0,

                ]);
                if ($create) {
                    $create = $create->toArray();
                    return $this->sendResponse($create, 200);
                }
            }
        } catch (Exception $error) {
            return $this->sendError($error->getMessage(), 400);
        }
    }

    function in(Request $request)
    {
        try {
            $user = new User;
            $user = $user->getUser($request['name']);
            if ($user) {
                $user->update(['isIn' => 1]);
                $user = $user->toArray();;
                return $this->sendResponse($user, 200);
            }
        } catch (Exception $error) {
            return $this->sendError($error->getMessage(), 400);
        }
    }

    public function out(Request $request)
    {
        try {
            $user = new User;
            $user = $user->getUser($request['name']);
            if ($user->update(['isIn' => 0])) {
                $response = "You've been out.";
                return response()->json($response);
            }
        } catch (Exception $error) {
            if (strpos($error->getMessage(), 'non-object') !== false) {
                $message = "User not found！";
                return $this->sendError($message, 400);
            }
            return $this->sendError($error->getMessage(), 400);
        }
    }

}

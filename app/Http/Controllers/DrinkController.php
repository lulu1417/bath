<?php

namespace App\Http\Controllers;
use App\User;
use App\Drink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DrinkController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
            Log::info($request->input());
            $user = new User;
            $user = $user->getUser($request['name']);
            $money = $user->getMoney($request['name']);
            $drink = new Drink;
            $drink_id = $drink->getID($request['drink_id']);
            $drink_name = $drink->getDrinkName($request['drink_id']);
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
    public function store(Request $request)
    {
        try {
                $request->validate([
                    'item' => ['required', 'unique:drinks'],
                    'price' => ['required', 'numeric', 'max:100000'],
                ]);

                $create = Drink::create([
                    'item' => $request['item'],
                    'price' => $request['price'],
                ]);
                $result = $create->toArray();
                if ($create) {
                    return $this->sendResponse($result, 200);
                }

        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

}

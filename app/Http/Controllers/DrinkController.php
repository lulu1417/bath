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
            $drink_id = $request['drink_id'];
            $drink_name = $drink->getDrinkName($request['drink_id']);
            $drink_price = $drink->getPrice($drink_id);
            $money -= $drink_price;

            if ($money > 0) {
                $user->update(['money' => $money, 'drink' => $drink_name]);
                if ($drink_id == 5) { //duck
                    $user->update(['drink' => $drink_name, 'isIn' => 2]);
                }
                if ($drink_id == 6) {
                    $user->update(['drink' => $drink_name, 'isIn' => 0]);
                }
                $result = $user->toArray();
                return $this->sendResponse($result, 200);
            } else {
                return $this->sendError("Your money is not enough.", 400);
            }

        } catch (Exception $error) {

            return $this->sendError($error, 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'item' => ['required', 'unique:drinks'],
                'price' => ['required', 'integer'],
                'image' => ['required', 'mimes:jpg,jpeg,bmp,png'],
            ]);
            $parameters = request()->all();
            if (request()->hasFile('image')) {
                $imageURL = request()->file('image')->store('public');
                $parameters['image'] = substr($imageURL, 7);
            } else {
                $e = "Please upload an image for item.";
                return $this->sendError($e->getMessage(), 400);
            }
            $create = Drink::create([
                'item' => $request['item'],
                'price' => $request['price'],
                'image' => $parameters['image'],
            ]);
            $result = $create->toArray();
            if ($parameters['image'] != null)
                $result['imageURL'] = asset('storage/' . $parameters['image']);
            if ($create) {
                return $this->sendResponse($result, 200);
            }
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{
    protected $fillable = [
        'item', 'price'
    ];
    function getID($id)
    {
        $ID = $this->find($id)->id;
        return $ID;
    }
    function getPrice($id)
    {
        $price = $this->find($id)->price;
        return $price;
    }
    function getDrinkName($id)
    {
        $name = $this->find($id)->item;
        return $name;
    }
}

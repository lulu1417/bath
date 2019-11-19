<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{
    protected $fillable = [
        'item', 'price', 'image'
    ];

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

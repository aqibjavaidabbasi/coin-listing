<?php

namespace App\Models;


use App\Models\CoinDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coin extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getImageAttribute($value)
    {
        return asset('storage/coins/' . $value);
    }

    public function coinDetail()
    {
        return $this->hasOne(CoinDetail::class, 'symbol', 'symbol');
    }

}

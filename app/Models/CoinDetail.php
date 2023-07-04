<?php

namespace App\Models;

use App\Models\Coin;
use Illuminate\Database\Eloquent\Model;

class CoinDetail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'coin_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'symbol',
        'slug',
        'cmc_rank',
        'total_supply',
        'price',
        'volume_24h',
        'market_cap',
    ];
    public function coin()
    {
        return $this->belongsTo(Coin::class, 'symbol', 'symbol');
    }
}

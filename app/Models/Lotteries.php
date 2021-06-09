<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lotteries extends Model
{
    use HasFactory;

    private static $lotteries = [
        'Powerball' => [
            'name' => 'Powerball',
            'url' => 'powerball',
            'date_founded' => '4/19/1992',
            'description' => 'description',
            'data_added' => '6/7/2021',
        ],
        'TX Lotto' => [
            'name' => 'Texas Lotto',
            'url' => 'txlotto',
            'date_founded' => '1/1/1833',
            'description' => 'description',
            'data_added' => '6/7/2021',
        ],
    ];

    public static function getLotteries()
    {
        return self::$lotteries;
    }
}

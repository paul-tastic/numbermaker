<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Powerball extends Model
{
    use HasFactory;
    protected $table = 'powerballs';
    protected $fillable = [
        'name',
        'draw_date',
        'b1',
        'b2',
        'b3',
        'b4',
        'b5',
        'powerball',
        'powerplay',
        'created_at',
        'updated_at',
    ];

    public static function getResults()
    {
        $results = Powerball::orderBy('draw_date', 'desc')->get();
        // sort result balls
        foreach ($results as $result) {
            $ball[0] = $result['b1'];
            $ball[1] = $result['b2'];
            $ball[2] = $result['b3'];
            $ball[3] = $result['b4'];
            $ball[4] = $result['b5'];
            sort($ball);
            $result['b1'] = $ball[0];
            $result['b2'] = $ball[1];
            $result['b3'] = $ball[2];
            $result['b4'] = $ball[3];
            $result['b5'] = $ball[4];
        }
        return $results;
    }

    public static function getRankedResults($results)
    {
        // given collection, return array with ranking
        for ($i = 1; $i < 70; $i++) {
            $ranked['numbers'][$i] = 0;
        }

        foreach ($results as $result) {
            // rank zones
            $ranked['zones'][$result['zoned']] = isset(
                $ranked['zones'][$result['zoned']]
            )
                ? ($ranked['zones'][$result['zoned']] += 1)
                : ($ranked['zones'][$result['zoned']] = 1);
            // rank balls
            $ranked['numbers'][$result->b1] += 1;
            $ranked['numbers'][$result->b2] += 1;
            $ranked['numbers'][$result->b3] += 1;
            $ranked['numbers'][$result->b4] += 1;
            $ranked['numbers'][$result->b5] += 1;
        }
        arsort($ranked['zones']);
        arsort($ranked['numbers']);

        return $ranked;
    }

    public static function insertDrawing($results)
    {
        $updatedCount = 0;
        foreach ($results as $result) {
            if (
                !Powerball::where(
                    'draw_date',
                    $result->field_draw_date
                )->exists()
            ) {
                $balls = explode(',', $result->field_winning_numbers);
                Powerball::insert([
                    'name' => 'Powerball',
                    'draw_date' => $result->field_draw_date,
                    'b1' => $balls[0],
                    'b2' => $balls[1],
                    'b3' => $balls[2],
                    'b4' => $balls[3],
                    'b5' => $balls[4],
                    'powerball' => $balls[5],
                    'powerplay' => $result->field_multiplier,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                $updatedCount++;
            }
        }
        return $updatedCount;
    }

    public static function getZones($results)
    {
        /* 
                5 zones:
                Z1: 1-14
                Z2: 15-28
                Z3: 29-42
                Z4: 43-56
                Z5: 57-69 (13 numbers)
            */

        foreach ($results as &$result) {
            $zone = '';
            for ($i = 1; $i < 6; $i++) {
                if ($result["b{$i}"] <= 14) {
                    $zone .= '1';
                } elseif ($result["b{$i}"] <= 28) {
                    $zone .= '2';
                } elseif ($result["b{$i}"] <= 42) {
                    $zone .= '3';
                } elseif ($result["b{$i}"] <= 56) {
                    $zone .= '4';
                } else {
                    $zone .= '5';
                }
            }
            $tAry = str_split($zone);
            sort($tAry);
            $result['zoned'] = implode('', $tAry);
        }
        return $results;
    }

    public static function getStats($results, $zoned, $ranked)
    {
        $stat['numberOfZonePatterns'] = count($ranked['zones']);
        $stat['numberOfDrawings'] = count($results);
        $stat['allTimeEven'] = 0;
        $stat['allTimeOdd'] = 0;

        for ($i = 0; $i < 7; $i++) {
            $stat['drawingEven'][$i] = 0;
            $stat['drawingOdd'][$i] = 0;
        }
        for ($i = 0; $i < 375; $i++) {
            $stat['ballTotal'][$i] = 0;
        }
        foreach ($results as $result) {
            // has any drawing been duplicated?
            $balls = "{$result['b1']}-{$result['b2']}-{$result['b3']}-{$result['b4']}-{$result['b5']}";

            $ballSmooshed[$balls] = isset($ballSmooshed[$balls])
                ? ($ballSmooshed[$balls] += 1)
                : ($ballSmooshed[$balls] = 1);

            // # even vs odd numbers for each draw
            // total odd/even all time
            $drawingEven = 0;
            $drawingOdd = 0;
            $ballTotal = 0;
            for ($i = 1; $i < 6; $i++) {
                $ballTotal += $result["b{$i}"];
                if ($result["b{$i}"] % 2 == 0) {
                    $drawingEven += 1;
                    $stat['allTimeEven'] += 1;
                } else {
                    $drawingOdd += 1;
                    $stat['allTimeOdd'] += 1;
                }
            }
            $stat['ballTotal'][$ballTotal] += 1;
            $stat['drawingEven'][$drawingEven] += 1;
            $stat['drawingOdd'][$drawingOdd] += 1;

            // see if those numbers string has been a winner

            // are the top 5 numbers in the right zones?
            // what are the top 5 numbers in each zone?

            // analyze powerball
        }

        // have the top 5 numbers ever hit together?
        $top5Arys = array_slice($ranked['numbers'], 0, 5, true);
        $top5KeysAry = [];
        foreach ($top5Arys as $key => $value) {
            array_push($top5KeysAry, $key);
        }
        $top5String = implode('-', $top5KeysAry);
        if (isset($ballSmooshed[$top5String])) {
            $stat['top5hitB4'] = 1;
            $stat['top5hitB4']['numbers'] = $top5String;
        } else {
            $stat['top5hitB4'] = 0;
        }

        arsort($stat['ballTotal']);
        if (max($ballSmooshed) > 1) {
            // a duplicate drawing! Let's capture them to display
            foreach ($ballSmooshed as $balls => $value) {
                $stat['duplicates'] = 1;
                $stat['duplicates']['pattern']['balls'] = $value;
            }
        } else {
            $stat['duplicates'] = 0;
        }
        dd($stat);
        return $stat;
    }

    public function getStrategies()
    {
        // have top 5 numbers ever won?
        // have last zone been repeater?
        // is there a pattern in the zones?
        // powerball consideration?
        // top 5 numbers in top 5 zones
        // prime numbers
        // fib numbers
        // fib sequence, reverse
    }
}

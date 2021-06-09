<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Powerball;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PowerballController extends Controller
{
    public function index()
    {
        // get balls
        $results = Powerball::getResults();

        // process strategies
        // simple ranking
        $zoned = Powerball::getZones($results);
        $ranked = Powerball::getRankedResults($results);
        //dd($ranked);
        $stats = Powerball::getStats($results, $zoned, $ranked);
        // render page
        return view('lotteries.powerball')->with([
            'results' => $results,
            'ranked' => $ranked,
            'stats' => $stats,
        ]);
    }

    public function updateWithoutKey()
    {
        $client = new Client(); //GuzzleHttp
        $url =
            'https://www.powerball.com/api/v1/numbers/powerball/recent10?_format=json';

        $response = $client->request('GET', $url, ['verify' => false]);
        $responseBody = json_decode($response->getBody());

        // check if draw_date already exists
        $updated = Powerball::insertDrawing($responseBody);

        if ($updated > 0) {
            Session::flash('message', [
                'text' => "$updated drawings added to the Powerball database.",
                'type' => 'success',
            ]);
        } else {
            Session::flash('message', [
                'text' => 'No drawings added to the Powerball database.',
                'type' => 'info',
            ]);
        }

        return redirect('admin/index');
    }
}

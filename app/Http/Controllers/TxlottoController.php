<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TxlottoController extends Controller
{
    public function txlotto()
    {
        $numbers = DB::table('txlottos')->get();

        return view('lotteries.txlotto')->with([
            'numbers' => $numbers,
        ]);
    }
}

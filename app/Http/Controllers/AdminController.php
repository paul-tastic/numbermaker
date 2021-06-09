<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Lotteries;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $lotteries = Lotteries::getLotteries();

        return view('admin.index')->with([
            'lotteries' => $lotteries,
        ]);
    }
}

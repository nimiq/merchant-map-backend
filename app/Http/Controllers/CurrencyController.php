<?php

namespace App\Http\Controllers;

use App\Models\Currency;

class CurrencyController extends Controller
{
    public function index()
    {
        return response()->json(Currency::all());
    }
}

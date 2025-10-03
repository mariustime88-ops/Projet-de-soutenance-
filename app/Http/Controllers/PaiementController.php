<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function index()
    {
        return view('paiement.index');
    }
}
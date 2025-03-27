<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use Illuminate\Http\Request;

class AdminAvisController extends Controller
{
    public function index()
    {
        $avis = Avis::all();
        return view('admin.avis.index', compact('avis'));
    }

}

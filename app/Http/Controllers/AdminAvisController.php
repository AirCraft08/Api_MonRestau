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


    public function destroy(string $id)
    {
        $avis = Avis::findOrFail($id);
        $avis->delete();

        return back()->with('success', "L'avis à bien été suprimé");
    }

}

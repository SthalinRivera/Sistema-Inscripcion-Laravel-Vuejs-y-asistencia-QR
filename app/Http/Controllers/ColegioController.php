<?php

namespace App\Http\Controllers;

use App\Models\Colegio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ColegioController extends Controller
{
    public function index(Request $request)
    {
        $colegio = DB::table('colegios')->select('ID_COLEGIO as id', DB::raw('concat(D_DIST, " - ",CEN_EDU, " - ",D_NIV_MOD) as nombre'))->where('D_PROV', $request->provColegio)
        //->orderBy('D_DIST', 'ASC')
        //->orderBy('CEN_EDU', 'DESC')
        ->orderByRaw("D_DIST ASC, FIELD(NIV_MOD, 'G0','D0', 'D1','D2','E0','L4', 'F0') DESC")
        ->get();
        //dd($pago);
        if($colegio==null){
            return response()->json(0);
        }else{
            return response()->json($colegio);  
        }
        
    }
    public function show(Colegio $colegio)
    {
        return response()->json([
            'colegio'=>$colegio
        ]);
    }
}

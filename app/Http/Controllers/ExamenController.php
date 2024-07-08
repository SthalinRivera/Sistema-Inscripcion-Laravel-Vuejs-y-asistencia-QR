<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use PHPUnit\TextUI\XmlConfiguration\Group;

class ExamenController extends Controller
{
    //
    public function obtener_data_aula($aula, $id_local_examen){

    }

    public function lista_aula(Request $request){
        $formato = isset($request->formato) ? $request->formato : null;
        $id_examen = isset($request->id_examen) ? $request->id_examen : null;
        $aula = isset($request->aula) ? $request->aula : null;
        $local_id = isset($request->local_id) ? $request->local_id : null;
        $id_aula = isset($request->id_aula) ? $request->id_aula : null;
        $nom_local = isset($request->nom_local) ? $request->nom_local : null;

/*         $aula = '02';
        $id_local_examen=1; */
        $postulantes = DB::table('fichas')
        ->join('modalidades', 'fichas.mcp_id_modalidad', '=', 'modalidades.id')
        ->join('carreras', 'fichas.mcp_id_carrera', '=', 'carreras.id')
        ->join('users', 'fichas.user_id', '=', 'users.id')
        ->join('aulas', 'fichas.id_aula', '=', 'aulas.id')
        ->select(
            'fichas.*',
            'modalidades.modalidad',
            'carreras.carrera',
            'carreras.nom_corto',
            'users.created_at as usuario_registro'
        )
        ->where('fichas.id_estado_revision', 3)
        ->whereNotNull('fichas.id_aula')
        ->where('aulas.local_id', $local_id);
        //->where('fichas.mcp_id_modalidad', 1)
        if ($id_aula) {
            $postulantes=$postulantes->where('aulas.id', $id_aula)->orderByRaw('fichas.dp_apellido_p, fichas.dp_apellido_m, fichas.dp_nombre');
        }else{
            $postulantes=$postulantes->orderBy('fichas.codigo_p');
        }
        /* ->where('fichas.aula_examen', $aula)
        ->where('fichas.id_local_examen', $id_local_examen) */
        $postulantes=$postulantes
        ->get();

        $data['formato']=$formato;
        $data['aula']=$aula;
        $data['nom_local']=$nom_local;
        $data['id_aula']=$id_aula;
        $data['data']=$postulantes;

        
        //dd($postulantes);
        $resultado['asd']['data']='asdasd';
        if($formato==1){
            $pdf = PDF::loadView('lista_aula',  $data)->setPaper('a4');  
        }elseif ($formato==2) {
            $pdf = PDF::loadView('lista_aula_calidad',  $data)->setPaper('a4', 'landscape');  
        }else{
            exit();
        }
        
        return $pdf->stream('lista de aula.pdf');
    }

    public function lista_general(Request $request){
        $formato = isset($request->formato) ? $request->formato : null;
        $id_examen = isset($request->id_examen) ? $request->id_examen : null;
        $aula = isset($request->aula) ? $request->aula : null;
        $local_id = isset($request->local_id) ? $request->local_id : null;
        $id_aula = isset($request->id_aula) ? $request->id_aula : null;
        $nom_local = isset($request->nom_local) ? $request->nom_local : null;

        $postulantes = DB::table('fichas')
        ->join('modalidades', 'fichas.mcp_id_modalidad', '=', 'modalidades.id')
        ->join('carreras', 'fichas.mcp_id_carrera', '=', 'carreras.id')
        ->join('users', 'fichas.user_id', '=', 'users.id')
        ->join('aulas', 'fichas.id_aula', '=', 'aulas.id')
        ->select(
            'fichas.*',
            'modalidades.modalidad',
            'carreras.carrera',
            'carreras.nom_corto',
            'users.created_at as usuario_registro',
            'aulas.aula as aula_postulante'
        )
        ->where('fichas.id_estado_revision', 3)
        ->whereNotNull('fichas.id_aula')
        ->where('aulas.local_id', $local_id)
        ->where('aulas.id_examen', $id_examen);
        
        $postulantes=$postulantes->orderByRaw('fichas.dp_apellido_p, fichas.dp_apellido_m, fichas.dp_nombre');
        /* ->where('fichas.aula_examen', $aula)
        ->where('fichas.id_local_examen', $id_local_examen) */
        $postulantes=$postulantes->get();

        $data['aula']=$aula;
        $data['formato']=$formato;
        $data['nom_local']=$nom_local;
        $data['local_id']=$local_id;
        $data['id_aula']=$id_aula;
        $data['data']=$postulantes;

        
        //dd($postulantes);
        $resultado['asd']['data']='asdasd';
        if($formato==1){
            $pdf = PDF::loadView('lista_general',  $data)->setPaper('a4');  
        }elseif ($formato==2) {
            $pdf = PDF::loadView('lista_aula_calidad',  $data)->setPaper('a4', 'landscape');  
        }else{
            exit();
        }
        
        return $pdf->stream('lista de aula.pdf');


    }

    public function aulas_postulantes(Request $request){
        $examen = isset($request->examen) ? $request->examen : null;
        $tipo_examen = isset($request->tipo_examen) ? $request->tipo_examen : null;
        $local = isset($request->local) ? $request->local : null;
       

        $aulas = DB::table('fichas')
        ->join('modalidades', 'fichas.mcp_id_modalidad', '=', 'modalidades.id')
        ->join('users', 'fichas.user_id', '=', 'users.id')
        ->join('aulas', 'fichas.id_aula', '=', 'aulas.id')
        ->join('locales', 'aulas.local_id', '=', 'locales.id')
        ->select(
            'fichas.*',
            'modalidades.modalidad',
            'users.created_at as usuario_registro',
            'aulas.id_examen',
            'aulas.aula',
            'aulas.local_id',
            'locales.local',
            DB::raw('count(fichas.id) as cantidad_aula'),
        )
        ->where('fichas.id_estado_revision', 3)
        ->whereNotNull('fichas.id_aula');
        if($tipo_examen){
            $aulas=$aulas->where('fichas.mcp_tipo', $tipo_examen);
        }
        if($examen){
            $aulas=$aulas->where('aulas.id_examen', $examen);
        }
        if($local){
            $aulas=$aulas->where('aulas.local_id', $local);
        }
        $aulas=$aulas->orderByRaw('aulas.id')
        ->groupBy('fichas.id_aula')
        ->get();
        return response()->json([
            //'ficha'=>$ficha,
            //'status'=>$status,
            //'success'=>$success,
            'aulas'=>$aulas
        ]);

    }

    public function listar_aulas(Request $request){
        $examen = isset($request->examen) ? $request->examen : null;
        $tipo_examen = isset($request->tipo_examen) ? $request->tipo_examen : null;
        $local = isset($request->local) ? $request->local : null;

        $aulas = DB::table('aulas')
        ->leftjoin('fichas', 'aulas.id', '=', 'fichas.id_aula')
        ->join('locales', 'aulas.local_id', '=', 'locales.id')
        ->select(
            'aulas.*',
            'locales.local',
            DB::raw('count(fichas.id) as cantidad'),
        ) 
        ->where('aulas.id_estado', 1)
        ->where('aulas.id_examen', $examen)
        ->where('aulas.local_id', $local)
        ->orderBy('aulas.id')
        ->groupBy('aulas.id')
        ->get();/*;
        $aulas=$aulas->orderBy('aulas.id')
        ->get();*/
        return response()->json([
            //'ficha'=>$ficha,
            //'status'=>$status,
            //'success'=>$success,
            'aulas'=>$aulas
        ]);
    }

    public function asignar_aulas(Request $request){
        $local = isset($request->local) ? $request->local : null;
        $id_aula = isset($request->id_aula) ? $request->id_aula : null;
        $cantidad = isset($request->cantidad) ? $request->cantidad : null;

        $changes=0;
        if($local && $id_aula && $cantidad){
            if($local==1){
                $affected = DB::table('fichas as f')
                    ->where('f.id_estado_revision', 3)
                    ->where('f.mcp_id_modalidad', 11)
                    // ->where('f.mcp_tipo', 2)
                    ->where(function ($query){
                        $query->where('f.mcp_tipo',1)
                              ->orWhere('f.mcp_tipo',2);
                    })
                    ->whereNull('f.id_aula')
                    // ->orderBy('f.codigo_p')
                    ->orderBy('f.dp_apellido_p')    //ordenar por orden de apellido
                    ->limit($cantidad)
                    ->update([
                            'f.id_aula' => $id_aula
                    ]);
                    $changes=$affected;
                
            }elseif($local==2){
                $affected = DB::table('fichas as f')
                    ->where('f.id_estado_revision', 3)
                    ->where('f.mcp_id_modalidad', 11)
                    ->where('f.mcp_tipo', 1)
                    ->whereNull('f.id_aula')
                    ->orderBy('f.codigo_p')
                    ->limit($cantidad)
                    ->update([
                            'f.id_aula' => $id_aula
                    ]);
                    $changes=$affected;
            }elseif($local==3){
                $affected = DB::table('fichas as f')
                    ->where('f.id_estado_revision', 3)
                    ->where('f.mcp_id_modalidad', 1)
                    ->where('f.mcp_tipo', 1)
                    ->whereNull('f.id_aula')
                    ->orderBy('f.dp_apellido_p')
                    ->limit($cantidad)
                    ->update([
                            'f.id_aula' => $id_aula
                    ]);
                    $changes=$affected;
            }elseif($local==4){
                $affected = DB::table('fichas as f')
                    ->where('f.id_estado_revision', 3)
                    ->where('f.mcp_id_modalidad', 1)
                    ->where('f.mcp_tipo', 1)
                    ->whereNull('f.id_aula')
                    ->orderBy('f.dp_apellido_p')
                    ->limit($cantidad)
                    ->update([
                            'f.id_aula' => $id_aula
                    ]);
                    $changes=$affected;
            }elseif($local==5){
                $affected = DB::table('fichas as f')
                    ->where('f.id_estado_revision', 3)
                    ->where('f.mcp_id_modalidad', 1)
                    ->where('f.mcp_tipo', 2)
                    ->whereNull('f.id_aula')
                    ->orderBy('f.dp_apellido_p')
                    ->limit($cantidad)
                    ->update([
                            'f.id_aula' => $id_aula
                    ]);
                    $changes=$affected;
            }
            
        }else{
            $changes=0;
            $status="false";
            $success=0;
        }
        return response()->json([
            'changes'=>$changes,
            //'success'=>$success,
        ]);
    }

    public function postulantes_sin_aulas(Request $request){
        $examen = isset($request->examen) ? $request->examen : null;
        

        $postulantes = DB::table('fichas')
        ->select(
            'fichas.mcp_tipo',
            DB::raw('count(fichas.id) as cantidad'),
            DB::raw('count(fichas.id_aula) as cantidad_asignado'),
            DB::raw('count(IF(fichas.id_aula IS NULL,1,NULL)) as no_asignado'),
        )
        ->where('fichas.id_estado_revision', 3);
        //->whereNull('fichas.id_aula')
        if($examen==2){
            $postulantes=$postulantes->where('fichas.mcp_id_modalidad', 11);
        }
        $postulantes=$postulantes->groupBy('fichas.mcp_tipo')
        ->get();
        return response()->json([
            //'ficha'=>$ficha,
            //'status'=>$status,
            //'success'=>$success,
            'postulantes'=>$postulantes
        ]);
    }
}

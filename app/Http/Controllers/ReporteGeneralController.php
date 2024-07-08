<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteGeneralController extends Controller
{
    // Función para Reporte General
    public function index(Request $request)
    {
        $modalidad = isset($request->modalidad) ? $request->modalidad : null;
        // INDICADORES DE PROCESO
        // Postulantes Pendientes Validar
        $canPendientes = DB::table('fichas')
            ->where('fichas.id_estado_revision', 1);
        if ($modalidad === 'extraordinario') {
            // Si la condición es 'extraordinario', busca los datos de todos los procesos extraordinarios
            $canPendientes->whereIn('fichas.mcp_id_modalidad', [2, 3, 10, 4, 5, 6, 7]);
        } elseif ($modalidad) {
            $canPendientes = $canPendientes->where('fichas.mcp_id_modalidad', $modalidad);
        }
        // if($modalidad){
        //     $canPendientes = $canPendientes->where('fichas.mcp_id_modalidad', $modalidad);
        // }
        $canPendientes = $canPendientes
            ->count();
        // Postulantes en Proceso
        $canPreInscritos = DB::table('fichas')
            ->where('fichas.id_estado', 1);
        if ($modalidad === 'extraordinario') {
            // Si la condición es 'extraordinario', busca los datos de todos los procesos extraordinarios
            $canPreInscritos->whereIn('fichas.mcp_id_modalidad', [2, 3, 10, 4, 5, 6, 7]);
        } elseif ($modalidad) {
            $canPreInscritos = $canPreInscritos->where('fichas.mcp_id_modalidad', $modalidad);
        }
        $canPreInscritos = $canPreInscritos
            ->whereNotIn('fichas.id_estado_revision', [3])
            ->count();
        // Postulantes Inscritos Validados
        $canInscritos = DB::table('fichas')
            ->where('fichas.id_estado_revision', 3);
        if ($modalidad === 'extraordinario') {
            // Si la condición es 'extraordinario', busca los datos de todos los procesos extraordinarios
            $canInscritos->whereIn('fichas.mcp_id_modalidad', [2, 3, 10, 4, 5, 6, 7]);
        } elseif ($modalidad) {
            $canInscritos = $canInscritos->where('fichas.mcp_id_modalidad', $modalidad);
        }
        // if($modalidad){
        //     $canInscritos = $canInscritos->where('fichas.mcp_id_modalidad', $modalidad);
        // }    
        $canInscritos = $canInscritos
            ->count();
        // Postulantes Totales con fichas entre Validados y en Proceso
        $totalProceso = DB::table('fichas')
            ->join('modalidades', 'fichas.mcp_id_modalidad', '=', 'modalidades.id');
        if ($modalidad === 'extraordinario') {
            // Si la condición es 'extraordinario', busca los datos de todos los procesos extraordinarios
            $totalProceso->whereIn('fichas.mcp_id_modalidad', [2, 3, 10, 4, 5, 6, 7]);
        } elseif ($modalidad) {
            $totalProceso = $totalProceso->where('fichas.mcp_id_modalidad', $modalidad);
        }
        // if($modalidad){
        //     $totalProceso = $totalProceso->where('fichas.mcp_id_modalidad', $modalidad);
        // }    
        $totalProceso = $totalProceso
            ->count();

        // INDICADORES DE CANTIDAD
        // Cantidad de Prospectos Vendidos
        $canProspecto = DB::table('pagos')
            ->join('fichas', 'pagos.id_ficha', '=', 'fichas.id')
            ->where('pagos.id_estado_revision', 3);
        if ($modalidad === 'extraordinario') {
            // Si la condición es 'extraordinario', busca los datos de todos los procesos extraordinarios
            $canProspecto->whereIn('fichas.mcp_id_modalidad', [2, 3, 10, 4, 5, 6, 7]);
        } elseif ($modalidad) {
            $canProspecto = $canProspecto->where('fichas.mcp_id_modalidad', $modalidad);
        }
        // if($modalidad){
        //     $canProspecto = $canProspecto->where('fichas.mcp_id_modalidad', $modalidad);
        // }    
        $canProspecto = $canProspecto
            ->whereIn('pagos.id_tipo_pago', [1, 3])
            ->count();
        // Cantidad de ventas de Derecho de Examen de Postulantes de colegio Público
        $canExamPubl = DB::table('colegios')
            ->join('fichas', 'colegios.id_colegio', '=', 'fichas.diep_id_colegio')
            ->join('pagos', 'fichas.id', '=', 'pagos.id_ficha')
            ->whereIn('colegios.gestion', [1, 2])
            ->where('pagos.id_estado_revision', 3)
            ->whereIn('pagos.id_tipo_pago', [2, 3, 5,6]);
        if ($modalidad === 'extraordinario') {
            // Si la condición es 'extraordinario', busca los datos de todos los procesos extraordinarios
            $canExamPubl->whereIn('fichas.mcp_id_modalidad', [2, 3, 10, 4, 5, 6, 7]);
        } elseif ($modalidad) {
            $canExamPubl = $canExamPubl->where('fichas.mcp_id_modalidad', $modalidad);
        }
        // if($modalidad){
        //     $canExamPubl = $canExamPubl->where('fichas.mcp_id_modalidad', $modalidad);
        // }    
        $canExamPubl = $canExamPubl
            ->count();
        // Cantidad de ventas de Derecho de Examen de Postulantes de colegio Privado
        $canExamPriv = DB::table('colegios')
            ->join('fichas', 'colegios.id_colegio', '=', 'fichas.diep_id_colegio')
            ->join('pagos', 'fichas.id', '=', 'pagos.id_ficha')
            ->where('colegios.gestion', 3)
            ->where('pagos.id_estado_revision', 3)
            ->whereIn('pagos.id_tipo_pago', [2, 3, 5, 6]);
        if ($modalidad === 'extraordinario') {
            // Si la condición es 'extraordinario', busca los datos de todos los procesos extraordinarios
            $canExamPriv->whereIn('fichas.mcp_id_modalidad', [2, 3, 10, 4, 5, 6, 7,]);
        } elseif ($modalidad) {
            $canExamPriv = $canExamPriv->where('fichas.mcp_id_modalidad', $modalidad);
        }
        // if($modalidad){
        //     $canExamPriv = $canExamPriv->where('fichas.mcp_id_modalidad', $modalidad);
        // }    
        $canExamPriv = $canExamPriv
            ->count();
        // Total de Postulantes que han Pagado su Derecho de Examen tanto de colégio Público cómo Privado
        $canPagoInscripcion = DB::table('pagos')
            ->join('fichas', 'pagos.id_ficha', '=', 'fichas.id')
            ->where('pagos.id_estado_revision', 3);
        if ($modalidad === 'extraordinario') {
            // Si la condición es 'extraordinario', busca los datos de todos los procesos extraordinarios
            $canPagoInscripcion->whereIn('fichas.mcp_id_modalidad', [2, 3, 10, 4, 5, 6, 7]);
        } elseif ($modalidad) {
            $canPagoInscripcion = $canPagoInscripcion->where('fichas.mcp_id_modalidad', $modalidad);
        }
        // if($modalidad){
        //     $canPagoInscripcion= $canPagoInscripcion->where('fichas.mcp_id_modalidad', $modalidad);
        // }    
        $canPagoInscripcion = $canPagoInscripcion
            ->whereIn('pagos.id_tipo_pago', [2, 3, 5, 6])
            ->count();
        // INDICADORES ECONÓMICOS
        // Monto de los Pagos por Prospecto
        $pagoProspectos = DB::table('pagos')
            ->join('fichas', 'pagos.id_ficha', '=', 'fichas.id')
            ->where('pagos.id_estado_revision', 3)
            ->whereIn('pagos.id_tipo_pago', [1, 3]);
        if ($modalidad === 'extraordinario') {
            // Si la condición es 'extraordinario', busca los datos de todos los procesos extraordinarios
            $pagoProspectos->whereIn('fichas.mcp_id_modalidad', [2, 3, 10, 4, 5, 6, 7]);
        } elseif ($modalidad) {
            $pagoProspectos = $pagoProspectos->where('fichas.mcp_id_modalidad', $modalidad);
        }
        // if($modalidad){
        //     $pagoProspectos = $pagoProspectos->where('fichas.mcp_id_modalidad', $modalidad);
        // }    
        $pagoProspectos = $pagoProspectos
            ->count() * 50;
        $pagoProspectos = number_format($pagoProspectos, 2, '.', ',');
        // Monto de los Pagos por Derecho de Examen de Colegio Público
        $pagoExamPublico = DB::table('colegios')
            ->join('fichas', 'colegios.id_colegio', '=', 'fichas.diep_id_colegio')
            ->join('pagos', 'fichas.id', '=', 'pagos.id_ficha')
            ->whereIn('colegios.gestion', [1, 2])
            ->where('pagos.id_estado_revision', 3)
            ->whereIn('pagos.id_tipo_pago', [2, 3, 5 , 6]);
        if ($modalidad === 'extraordinario') {
            // Si la condición es 'extraordinario', busca los datos de todos los procesos extraordinarios
            $pagoExamPublico->whereIn('fichas.mcp_id_modalidad', [2, 3, 10, 4, 5, 6, 7]);
        } elseif ($modalidad) {
            $pagoExamPublico = $pagoExamPublico->where('fichas.mcp_id_modalidad', $modalidad);
        }
        // if($modalidad){
        //     $pagoExamPublico = $pagoExamPublico->where('fichas.mcp_id_modalidad', $modalidad);
        // }   
        $pagoExamPublico = $pagoExamPublico
            ->selectRaw('SUM(
                CASE
                    WHEN pagos.id_tipo_pago = 3 THEN pagos.monto_pago - 50
                    ELSE pagos.monto_pago
                END
            ) as pagoExamPublico')
            ->first();
        $pagoExamPublico = number_format($pagoExamPublico->pagoExamPublico, 2, '.', ',');
        // Monto de los Pagos por Derecho de Examen de Colegio Privado
        $pagoExamPrivado = DB::table('colegios')
            ->join('fichas', 'colegios.id_colegio', '=', 'fichas.diep_id_colegio')
            ->join('pagos', 'fichas.id', '=', 'pagos.id_ficha')
            ->where('colegios.gestion', 3)
            ->where('pagos.id_estado_revision', 3)
            ->whereIn('pagos.id_tipo_pago', [2, 3, 5, 6]);
        if ($modalidad === 'extraordinario') {
            // Si la condición es 'extraordinario', busca los datos de todos los procesos extraordinarios
            $pagoExamPrivado->whereIn('fichas.mcp_id_modalidad', [2, 3, 10, 4, 5, 6, 7]);
        } elseif ($modalidad) {
            $pagoExamPrivado = $pagoExamPrivado->where('fichas.mcp_id_modalidad', $modalidad);
        }
        // if($modalidad){
        //     $pagoExamPrivado = $pagoExamPrivado->where('fichas.mcp_id_modalidad', $modalidad);
        // }    
        $pagoExamPrivado = $pagoExamPrivado
            ->selectRaw('SUM(
                CASE
                    WHEN pagos.id_tipo_pago = 3 THEN pagos.monto_pago - 50
                    ELSE pagos.monto_pago
                END
            ) as pagoExamPrivado')
            ->first();
        $pagoExamPrivado = number_format($pagoExamPrivado->pagoExamPrivado, 2, '.', ',');
        // Monto Total de la venta por Derecho de Examen
        $pagoTotal = DB::table('pagos')
            ->join('fichas', 'pagos.id_ficha', '=', 'fichas.id')
            ->where('pagos.id_estado_revision', 3);
        if ($modalidad === 'extraordinario') {
            // Si la condición es 'extraordinario', busca los datos de todos los procesos extraordinarios
            $pagoTotal->whereIn('fichas.mcp_id_modalidad', [2, 3, 10, 4, 5, 6, 7]);
        } elseif ($modalidad) {
            $pagoTotal = $pagoTotal->where('fichas.mcp_id_modalidad', $modalidad);
        }
        // if($modalidad){
        //     $pagoTotal = $pagoTotal->where('fichas.mcp_id_modalidad', $modalidad);
        // }    
        $pagoTotal = $pagoTotal
            ->sum('pagos.monto_pago');
        $pagoTotal = number_format($pagoTotal, 2, '.', ',');
        // REPORTE GENERAL
        $canUsuarios = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('model_has_roles.role_id', 3)
            ->where('users.interesado', 1)
            ->where('users.id_estado', 1)
            ->count();
        $reporteGeneral[0] = [
            'nombre' => 'USUARIOS REGISTRADOS',
            'cantidad' => $canUsuarios,
            'porcentaje' => (100 / 400) * $canUsuarios
        ];
        $reporteGeneral[1] = [
            'nombre' => 'PROSPECTO VENDIDO',
            'cantidad' => $canProspecto,
            'porcentaje' => (100 / 400) * $canProspecto
        ];
        $reporteGeneral[2] = [
            'nombre' => 'PAGOS POR INSCRIPCIÓN',
            'cantidad' => $canPagoInscripcion,
            'porcentaje' => (100 / 400) * $canPagoInscripcion
        ];
        $reporteGeneral[3] = [
            'nombre' => 'USUARIOS PRE-INSCRITOS',
            'cantidad' => $canPreInscritos,
            'porcentaje' => (100 / 400) * $canPreInscritos
        ];
        $reporteGeneral[4] = [
            'nombre' => 'POSTULANTES INSCRITOS',
            'cantidad' => $canInscritos,
            'porcentaje' => (100 / 400) * $canInscritos
        ];
        $reporteGeneral[5] = [
            'nombre' => 'POSTULANTES PENDIENTE A VALIDACIÓN',
            'cantidad' => $canPendientes,
            'porcentaje' => (100 / 400) * $canPendientes
        ];
        //REPORTE POR FECHA
        $canUsuariosDia = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('fichas', 'users.id', '=', 'fichas.user_id')
            ->where('model_has_roles.role_id', 3)
            ->where('users.id_estado', 1)
            ->whereNotNull('fichas.mcp_id_modalidad')
            ->select(DB::raw("DATE_FORMAT(users.created_at,'%Y-%m-%d') AS x"), DB::raw("COUNT(users.id) AS y"))
            ->groupBy('x')
            ->get();
        $canProspectoDia = DB::table('pagos')
            ->join('fichas', 'pagos.id_ficha', '=', 'fichas.id')
            ->where('pagos.id_estado_revision', 3)
            ->whereNotNull('fichas.mcp_id_modalidad', )
            ->whereIn('pagos.id_tipo_pago', [1, 3])
            ->select(DB::raw("DATE_FORMAT(pagos.fecha_revisado,'%Y-%m-%d') AS x"), DB::raw("COUNT(pagos.id) AS y"))
            ->groupBy('x')
            ->get();
        // $canInscritosDia = [];
        $canInscritosDia = DB::table('fichas')
            ->where('fichas.id_estado_revision', 3)
            ->whereNotNull('fichas.mcp_id_modalidad')
            ->select(DB::raw("DATE_FORMAT(fichas.fecha_revisado,'%Y-%m-%d') AS x"), DB::raw("COUNT(fichas.id) AS y"))
            ->groupBy('x')
            ->get();
        $canUsuariosDia = $this->completar_fechas('2023-09-10', $canUsuariosDia);
        $canProspectoDia = $this->completar_fechas('2023-09-10', $canProspectoDia);
        $canInscritosDia = $this->completar_fechas('2023-09-10', $canInscritosDia);
        $dia['canUsuariosDia'] = $canUsuariosDia;
        $dia['canProspectosDia'] = $canProspectoDia;
        $dia['canInscritosDia'] = $canInscritosDia;
        // REPORTE POR MODALIDADES
        $canModalidad_a = DB::table('fichas AS f')
            ->join('modalidades AS m', 'f.mcp_id_modalidad', '=', 'm.id')
            ->whereNotNull('f.mcp_id_modalidad')
            ->select(
                DB::raw("(SELECT 'TOTAL') AS modalidad"),
                DB::raw("COUNT(m.id) AS total"),
                DB::raw("COUNT(IF(f.id_estado_revision=3, 1, NULL)) AS inscritos"),
                DB::raw("COUNT(IF(f.id_estado_revision!=3, 1, NULL)) AS proceso")
            );
        $canModalidad = DB::table('fichas AS f')
            ->join('modalidades AS m', 'f.mcp_id_modalidad', '=', 'm.id')
            ->whereNotNull('f.mcp_id_modalidad')
            ->select(
                'm.modalidad',
                DB::raw("COUNT(m.id) AS total"),
                DB::raw("COUNT(IF(f.id_estado_revision=3, 1, NULL)) AS inscritos"),
                DB::raw("COUNT(IF(f.id_estado_revision!=3, 1, NULL)) AS proceso")
            )
            ->groupBy('m.id')
            ->union($canModalidad_a)
            ->get();
        if ($canUsuarios == null) {
            return response()->json(0);
        } else {
            return response()->json([
                // Llamado a la variable de instancia para que se retorne
                // Variables de instancia de Indicadores de Proceso
                'modalidades' => $canModalidad,
                'canPendientes' => $canPendientes,
                'canPreInscritos' => $canPreInscritos,
                'canInscritos' => $canInscritos,
                'totalProceso' => $totalProceso,
                'canUsuarios' => $canUsuarios,
                // Variables de instancia de Indicadores de Cantidad
                'canProspecto' => $canProspecto,
                'canExamPubl' => $canExamPubl,
                'canExamPriv' => $canExamPriv,
                'canPagoInscripcion' => $canPagoInscripcion,
                // Variables de instancia de Indicadores Económicos
                'pagoProspectos' => $pagoProspectos,
                'pagoExamPublico' => $pagoExamPublico,
                'pagoExamPrivado' => $pagoExamPrivado,
                'pagoTotal' => $pagoTotal,

                'general' => $reporteGeneral,
                'canUsuariosDia' => $canUsuariosDia,
                'dia' => $dia

            ]);
        }
    }

    function completar_fechas($fecha, $objeto)
    {
        $datos = [];
        $fecha_actual = date('Y-m-d');
        $json = json_encode($objeto);
        $objeto = json_decode($json, true);
        for ($fecha_inicio = date("Y-m-d", strtotime($fecha)); $fecha_inicio <= $fecha_actual; $fecha_inicio = date("Y-m-d", strtotime($fecha_inicio . "+ 1 days"))) {
            $keys = array_column($objeto, 'x');
            $index = array_search($fecha_inicio, $keys);
            if (is_numeric($index)) {
                array_push($datos, $objeto[$index]);
            } else {
                array_push($datos, [
                    'x' => $fecha_inicio,
                    'y' => 0,
                ]);
            }
        }
        return $datos;
    }
    public function reporte_carrera(Request $request)
    {
        $modalidad = isset($request->modalidad) ? $request->modalidad : null;
        $resultado = DB::table('fichas')
            ->where('fichas.id_estado_revision', 3);
        if ($modalidad) {
            $resultado = $resultado->where('fichas.mcp_id_modalidad', $modalidad);
        }
        $resultado = $resultado
            ->join('carreras', 'fichas.mcp_id_carrera', '=', 'carreras.id')
            ->select(DB::raw("carreras.carrera AS x"), DB::raw("COUNT(fichas.id) AS y"))
            ->groupBy('x')
            ->orderBy('fichas.mcp_id_carrera')
            ->get();
        return response()->json([
            'carrera' => $resultado
        ]);
    }
    public function reporte_modalidad(Request $request)
    {
        $carrera = isset($request->carrera) ? $request->carrera : null;
        $resultado = DB::table('fichas')
            ->where('fichas.id_estado_revision', 3);
        if ($carrera) {
            $resultado = $resultado->where('fichas.mcp_id_carrera', $carrera);
        }
        $resultado = $resultado->join('modalidades', 'fichas.mcp_id_modalidad', '=', 'modalidades.id')
            ->select(DB::raw("modalidades.modalidad AS x"), DB::raw("COUNT(fichas.id) AS y"))
            ->groupBy('x')
            ->orderBy('fichas.mcp_id_modalidad')
            ->get();

        $modCepre = DB::table('fichas AS f')
            ->join('modalidades AS m', 'f.mcp_id_modalidad', '=', 'm.id')
            ->where('f.mcp_id_modalidad', 8);
        if ($carrera) {
            $modCepre = $modCepre->where('f.mcp_id_carrera', $carrera);
        }
        $modCepre = $modCepre->select(
            'm.modalidad',
            DB::raw("COUNT(m.id) AS total"),
            DB::raw("COUNT(IF(f.id_estado_revision=3, 1, NULL)) AS inscritos"),
            DB::raw(
                "COUNT(IF(f.id_estado_revision!=3, 1, NULL)) AS proceso"
            )
        )
            ->groupBy('m.id')
            ->get();

        $modQuinto = DB::table('fichas AS f')
            ->join('modalidades AS m', 'f.mcp_id_modalidad', '=', 'm.id')
            ->where('f.mcp_id_modalidad', 11);
        if ($carrera) {
            $modQuinto = $modQuinto->where('f.mcp_id_carrera', $carrera);
        }
        $modQuinto = $modQuinto->select(
            'm.modalidad',
            DB::raw("COUNT(m.id) AS total"),
            DB::raw("COUNT(IF(f.id_estado_revision=3, 1, NULL)) AS inscritos"),
            DB::raw(
                "COUNT(IF(f.id_estado_revision!=3, 1, NULL)) AS proceso"
            )
        )
            ->groupBy('m.id')
            ->get();

        $modOrdinario = DB::table('fichas AS f')
            ->join('modalidades AS m', 'f.mcp_id_modalidad', '=', 'm.id')
            ->where('f.mcp_id_modalidad', 1);
        if ($carrera) {
            $modOrdinario = $modOrdinario->where('f.mcp_id_carrera', $carrera);
        }
        $modOrdinario = $modOrdinario->select(
            'm.modalidad',
            DB::raw("COUNT(m.id) AS total"),
            DB::raw("COUNT(IF(f.id_estado_revision=3, 1, NULL)) AS inscritos"),
            DB::raw(
                "COUNT(IF(f.id_estado_revision!=3, 1, NULL)) AS proceso"
            )
        )
            ->groupBy('m.id')
            ->get();

        $modExtraordinario = DB::table('fichas AS f')
            ->join('modalidades AS m', 'f.mcp_id_modalidad', '=', 'm.id')
            ->whereIn('f.mcp_id_modalidad', [2, 3, 10, 4, 5, 6, 7]);
        if ($carrera) {
            $modExtraordinario = $modExtraordinario->where('f.mcp_id_carrera', $carrera);
        }
        $modExtraordinario = $modExtraordinario->select(
            DB::raw("(SELECT 'EXTRAORDINARIO') AS modalidad"),
            DB::raw("COUNT(m.id) AS total"),
            DB::raw("COUNT(IF(f.id_estado_revision=3, 1, NULL)) AS inscritos"),
            DB::raw("COUNT(IF(f.id_estado_revision!=3, 1, NULL)) AS proceso")
        )
            ->get();

        $subModalidades = DB::table('fichas AS f')
            ->join('modalidades AS m', 'f.mcp_id_modalidad', '=', 'm.id')
            ->whereIn('f.mcp_id_modalidad', [2, 3, 10, 4, 5, 6, 7]);
        if ($carrera) {
            $subModalidades = $subModalidades->where('f.mcp_id_carrera', $carrera);
        }
        $subModalidades = $subModalidades->select(
            'm.modalidad',
            DB::raw("COUNT(m.id) AS total"),
            DB::raw("COUNT(IF(f.id_estado_revision=3, 1, NULL)) AS inscritos"),
            DB::raw(
                "COUNT(IF(f.id_estado_revision!=3, 1, NULL)) AS proceso"
            )
        )
            ->groupBy('m.id')
            ->get();
        return response()->json([
            'modalidad' => $resultado,
            'modCepre' => $modCepre,
            'modQuinto' => $modQuinto,
            'modOrdinario' => $modOrdinario,
            'modExtraordinario' => $modExtraordinario,
            'subModalidades' => $subModalidades
        ]);


    }
    public function reporte_colegios(Request $request)
    {
        $id_provincia = isset($request->id_provincia) ? $request->id_provincia : null;
        $modalidad = isset($request->modalidad) ? $request->modalidad : null;
        $carrera = isset($request->carrera) ? $request->carrera : null;
        $resultado = DB::table('fichas')
            ->join('distritos', 'fichas.da_dis', '=', 'distritos.id_distrito')
            ->join('provincias', 'distritos.id_provincia', '=', 'provincias.id_provincia')
            ->join('colegios', 'fichas.diep_id_colegio', '=', 'colegios.ID_COLEGIO')
            ->where('fichas.id_estado_revision', 3);
        if ($id_provincia) {
            $resultado = $resultado->where('distritos.id_provincia', $id_provincia);
        }
        if ($modalidad) {
            $resultado = $resultado->where('fichas.mcp_id_modalidad', $modalidad);
        }
        if ($carrera) {
            $resultado = $resultado->where('fichas.mcp_id_carrera', $carrera);
        }
        $resultado = $resultado
            ->select(
                DB::raw("provincias.provincia AS provincia"),
                DB::raw("colegios.CEN_EDU AS x"),
                DB::raw("distritos.distrito AS distrito"),
                DB::raw("COUNT(fichas.id) AS y")
            )
            ->groupBy('x')
            // ->orderBy('fichas.da_prov')
            ->orderBy('fichas.diep_id_colegio')
            ->get();
        return response()->json([
            'colegios' => $resultado
        ]);
    }
    public function reporte_distrito(Request $request)
    {
        $id_provincia = isset($request->id_provincia) ? $request->id_provincia : null;
        $modalidad = isset($request->modalidad) ? $request->modalidad : null;
        $carrera = isset($request->carrera) ? $request->carrera : null;
        $resultado = DB::table('fichas')
            ->join('distritos', 'fichas.da_dis', '=', 'distritos.id_distrito')
            ->join('provincias', 'distritos.id_provincia', '=', 'provincias.id_provincia')
            ->where('fichas.id_estado_revision', 3);
        if ($id_provincia) {
            $resultado = $resultado->where('distritos.id_provincia', $id_provincia);
        }
        if ($modalidad) {
            $resultado = $resultado->where('fichas.mcp_id_modalidad', $modalidad);
        }
        if ($carrera) {
            $resultado = $resultado->where('fichas.mcp_id_carrera', $carrera);
        }
        $resultado = $resultado
            ->select(
                DB::raw("provincias.provincia AS provincia"),
                DB::raw("distritos.distrito AS x"),
                DB::raw("COUNT(fichas.id) AS y")
            )
            ->groupBy('x')
            ->orderBy('fichas.da_prov')
            ->get();

        return response()->json([
            'distrito' => $resultado
        ]);
    }
    public function reporte_publicidad(Request $request)
    {
        $id_provincia = isset($request->id_provincia) ? $request->id_provincia : null;
        $modalidad = isset($request->modalidad) ? $request->modalidad : null;
        $carrera = isset($request->carrera) ? $request->carrera : null;
        $resultado = DB::table('fichas')
            ->join('distritos', 'fichas.da_dis', '=', 'distritos.id_distrito')
            ->where('fichas.id_estado_revision', 3);
        if ($modalidad) {
            $resultado = $resultado->where('fichas.mcp_id_modalidad', $modalidad);
        }
        $resultado = $resultado
            ->select(DB::raw("fichas.dd_publicidad AS x"), DB::raw("COUNT(fichas.id) AS y"))
            ->groupBy('x')
            ->orderBy('fichas.dd_publicidad')
            ->get();

        return response()->json([
            'publicidad' => $resultado
        ]);
    }
    public function reporte_fecha(Request $request)
    {
        $modalidad = isset($request->modalidad) ? $request->modalidad : null;        
        $desde = isset($request->desde) ? $request->desde : null;
        $hasta = isset($request->hasta) ? $request->hasta : null;
        //REPORTE POR FECHA
        $canProcesoDia = DB::table('fichas')
            ->where('id_estado', 1);
            if ($modalidad === 'extraordinario') {
                // Si la condición es 'extraordinario', busca los datos de todos los procesos extraordinarios
                $canProcesoDia->whereIn('mcp_id_modalidad', [2, 3, 10, 4, 5, 6, 7]);
            } elseif ($modalidad) {
                $canProcesoDia = $canProcesoDia->where('mcp_id_modalidad', $modalidad);
            }
            $canProcesoDia = $canProcesoDia
            ->when($desde && $hasta, function ($query) use ($desde, $hasta) {
                $hasta = date('Y-m-d', strtotime($hasta . ' +1 day'));
                return $query->whereBetween('created_at', [$desde, $hasta]);
            })
            ->whereNotIn('id_estado_revision', [3])
            ->select(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') AS x"), DB::raw("COUNT(id) AS y"))
            ->groupBy('x')
            ->get();
        $canInscritosDia = DB::table('fichas')
            ->where('id_estado_revision', 3);
            if ($modalidad === 'extraordinario') {
                // Si la condición es 'extraordinario', busca los datos de todos los procesos extraordinarios
                $canInscritosDia->whereIn('mcp_id_modalidad', [2, 3, 10, 4, 5, 6, 7]);
            } elseif ($modalidad) {
                $canInscritosDia = $canInscritosDia->where('mcp_id_modalidad', $modalidad);
            }
            $canInscritosDia = $canInscritosDia
            ->when($desde && $hasta, function ($query) use ($desde, $hasta) {
                $hasta = date('Y-m-d', strtotime($hasta . ' +1 day'));
                return $query->whereBetween('fecha_revisado', [$desde, $hasta]);
            })
            ->select(DB::raw("DATE_FORMAT(fecha_revisado,'%Y-%m-%d') AS x"), DB::raw("COUNT(id) AS y"))
            ->groupBy('x')
            ->get();
        
        if (!empty($desde)) {
            $canProcesoDia = $this->completar_fechas($desde, $canProcesoDia);
        } else {
            $canProcesoDia = $this->completar_fechas('2023-10-10', $canProcesoDia);
        }
        if (!empty($desde)) {
            $canInscritosDia = $this->completar_fechas($desde, $canInscritosDia);
        } else {
            $canInscritosDia = $this->completar_fechas('2023-10-10', $canInscritosDia);
        }
        // $canProcesoDia = $this->completar_fechas('2023-09-10', $canProcesoDia);
        // $canInscritosDia = $this->completar_fechas('2023-09-10', $canInscritosDia);
        $dia['canProcesoDia'] = $canProcesoDia;
        $dia['canInscritosDia'] = $canInscritosDia;

        $modalidadFilter = '';
        if ($modalidad !== null) {
            $modalidadFilter = ($modalidad === 'extraordinario') ? 'IN (2, 3, 10, 4, 5, 6, 7)' : '= ' . $modalidad;
        }
        $fechaCondition1 = '';
        if ($desde && $hasta) {
            $fechaCondition1 = 'AND DATE_FORMAT(created_at, "%Y-%m-%d") BETWEEN "' . $desde . '" AND "' . $hasta . '"';
        }
        $fechaCondition2 = '';
        if ($desde && $hasta) {
            $fechaCondition2 = 'AND DATE_FORMAT(fecha_revisado, "%Y-%m-%d") BETWEEN "' . $desde . '" AND "' . $hasta . '"';
        }

        $estadisticafecha_a = DB::table(DB::raw('(SELECT DATE_FORMAT(created_at, "%Y-%m-%d") AS fecha, COUNT(id) AS proceso, 0 AS inscritos
                    FROM fichas
                    WHERE id_estado = 1
                    AND mcp_id_modalidad ' .$modalidadFilter . '
                    AND id_estado_revision NOT IN (3)
                    ' . $fechaCondition1 . '
                    GROUP BY DATE_FORMAT(created_at, "%Y-%m-%d")
                    UNION ALL
                    SELECT DATE_FORMAT(fecha_revisado, "%Y-%m-%d") as fecha, 0 AS proceso, COUNT(id) as inscritos
                    FROM fichas
                    WHERE mcp_id_modalidad ' .$modalidadFilter . '
                    AND id_estado_revision = 3
                    ' . $fechaCondition2 . '
                    GROUP BY DATE_FORMAT(fecha_revisado, "%Y-%m-%d")) AS combined'))
            ->select(DB::raw('"TOTAL" as fecha'), DB::raw('SUM(proceso) as proceso'), DB::raw('SUM(inscritos) AS inscritos'));

        $estadisticafecha = DB::table(DB::raw('(SELECT DATE_FORMAT(created_at, "%Y-%m-%d") AS fecha, COUNT(id) AS proceso, 0 AS inscritos
                    FROM fichas
                    WHERE id_estado = 1
                    AND mcp_id_modalidad ' .$modalidadFilter . '
                    AND id_estado_revision NOT IN (3)
                    ' . $fechaCondition1 . '
                    GROUP BY DATE_FORMAT(created_at, "%Y-%m-%d")
                    UNION ALL
                    SELECT DATE_FORMAT(fecha_revisado, "%Y-%m-%d") as fecha, 0 AS proceso, COUNT(id) as inscritos
                    FROM fichas
                    WHERE mcp_id_modalidad ' .$modalidadFilter . '
                    AND id_estado_revision = 3
                    ' . $fechaCondition2 . '
                    GROUP BY DATE_FORMAT(fecha_revisado, "%Y-%m-%d")) AS combined'))
            ->select('fecha', DB::raw('SUM(proceso) AS proceso'), DB::raw('SUM(inscritos) AS inscritos'))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->union($estadisticafecha_a)
            ->get();

        return response()->json([
            'estadisticafecha' => $estadisticafecha,
            'canProcesoDia' => $canProcesoDia,
            'dia' => $dia
        ]);
    }

}

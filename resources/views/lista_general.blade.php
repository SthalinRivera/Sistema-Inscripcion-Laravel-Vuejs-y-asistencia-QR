<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LISTADO GENERAL 
        @isset($local_id)
            @if($local_id==1)
                - CASA DE LA CULTURA
            @elseif($local_id==2)
                - I.E. 20188 "CENTRO DE MUJERES"
            @elseif($local_id==3)
                - CAMPUS UNIVERSITARIO FUNDO DON LUIS
            @elseif($local_id==4)
                - CAMPUS UNIVERSITARIO FUNDO DON LUIS
            @elseif($local_id==5)
                - CAMPUS UNIVERSITARIO FUNDO DON LUIS
            @endif
        @endisset
    </title>
</head>
<style>
    th, td{
        border: 1px solid
    }
</style>
<body>
    <div style="text-align:center">
        <h4 style="margin: 0;">REGISTRO DE POSTULANTES DEL EXAMEN ORDINARIO 2024</h4>
        <h4 style="margin: 0;">
            EXAMEN ORDINARIO 2024
        </h4>
        <h4 style="margin: 0;">
            DOMINGO 25 DE FEBRERO
        </h4>
        @if($id_aula)
            <h4 style="margin: 0;">
                AULA {{$aula}}
            </h4>
        @else
        <h4 style="margin: 0;">
            LISTADO GENERAL 
            @isset($local_id)
                @if($local_id==1)
                    - CASA DE LA CULTURA
                @elseif($local_id==2)
                    - I.E. 20188 "CENTRO DE MUJERES"
                @elseif($local_id==3)
                    - CAMPUS UNIVERSITARIO FUNDO DON LUIS
                @elseif($local_id==4)
                    - CAMPUS UNIVERSITARIO FUNDO DON LUIS
                @elseif($local_id==5)
                    - CAMPUS UNIVERSITARIO FUNDO DON LUIS
                @endif
            @endisset
        </h4>
        @endif
        
    </div>
    <br>
    <div style="">
        <table class="table" style="border-collapse: collapse;font-size: 13px;margin: 0 auto;">
            <thead>
                <tr style="background: rgb(205, 200, 200)">
                    <th scope="col" style="width: 20px; text-align:center">N°</th>
                    <th scope="col" style="width: 65px; text-align:center">CÓDIGO</th>
                    <th scope="col" style="width: 340px">APELLIDOS Y NOMBRES</th>
                    <th scope="col" style="width: 75px; text-align:center">DNI</th>
                    <th scope="col" style="width: 140px; text-align:center">CARRERA</th>
                    <th scope="col" style="width: 20px; text-align:center">AULA</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $postulante)
                    <tr>
                        <th scope="row">{{ $loop->index+1}}</th>
                        <td style="text-align:center">{{$postulante->codigo_p}}</td>
                        <td>{{$postulante->dp_apellido_p.' '.$postulante->dp_apellido_m.' '.$postulante->dp_nombre}}</td>
                        <td style="text-align:center">{{$postulante->numero_documento}}</td>
                        <td style="text-align:center">{{$postulante->nom_corto}}</td>
                        <td style="text-align:center">{{$postulante->aula_postulante}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    
    
      {{-- <h1>{{$data}}</h1> --}}
</body>
</html>

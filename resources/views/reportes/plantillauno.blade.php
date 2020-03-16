<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{strtotime(\Carbon\Carbon::now())}}</title>
    <style>
        @page{
            margin: 0%;
            padding: 0%;
            font-family: 'Anton', sans-serif;
            color: orangered;
            font-size: 30px
        }
        @import url('https://fonts.googleapis.com/css?family=Anton&display=swap');
        .firstimg{
            width:100%;
            height:792px;
            position: relative;
        }
        .centrado{
            position: absolute;
            top: 48.5%;
            left: 13%;
            width: 85%;
        }
        .capturas{
            position: absolute;
            top: 11%;
            left: 7%;
            width: 86%;
            height: 680px;
        }
        .texto_descripcion{
            position: absolute;
            top: 10%;
            left: 10%;
            width: 80%;
            max-height: 70%;
            color: aliceblue;
            text-align: center;
        }
        .page_break { page-break-before: always; }
    </style>
</head>
<body>
    <img class="firstimg" src="{{asset('/images/reporte/portada.jpg')}}" alt="">
    <div class="page-break"></div>
    <img src="{{asset('/images/reporte/paginaintro.jpg')}}" alt="" class="firstimg">
    <p class="centrado">Presentación de medios pautados para la marca {{$marca}}</p>
    <div class="page-break"></div>
    @foreach ($capturas as $item)
        <img src="{{asset('/images/reporte/plantilla.jpg')}}" alt="" class="firstimg">
        <img src="{{asset('storage/'.$item)}}" alt="" class="capturas">
        <div class="page_break"></div>
    @endforeach
    <img class="firstimg" src="{{asset('/images/reporte/final.jpg')}}" alt="">
    <div class="texto_descripcion">
        {{$descripcion}}
    </div>
</body>
</html>
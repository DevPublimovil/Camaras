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
            padding: 0%
        }
        .firstimg{
            width:100%;
            height:792px;
            position: relative;
        }
        .centrado{
            position: absolute;
            top: 53%;
            left: 40%;
            font-weight: 500;
            transform: translate(-50%, -50%);
            color: orangered;
            font-size: 30px;
            border-color:red 1px solid
        }
        .capturas{
            position: absolute;
            top: 11%;
            left: 7%;
            width: 86%;
            height: 600px;
        }
        /* html{
            background-image: url('./images/bg_reporte.png');
            max-width:100%;
            height:auto
        } */
        .page_break { page-break-before: always; }
    </style>
</head>
<body>
    <img class="firstimg" src="{{public_path('/images/bg_reporte.png')}}" alt="">
    <div class="page-break"></div>
    <img src="{{public_path('/images/bg-dos.png')}}" alt="" class="firstimg">
    <p class="centrado">{{$descripcion}}</p>
    <div class="page-break"></div>
    {{-- {{$descripcion}} --}}
    @foreach ($capturas as $item)
        <img src="{{public_path('/images/bg-tres.png')}}" alt="" class="firstimg">
        <img src="{{public_path($item)}}" alt="" class="capturas">
        @if (!$loop->last)
            <div class="page_break"></div>
        @endif
    @endforeach
</body>
</html>
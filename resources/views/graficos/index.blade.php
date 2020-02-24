@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-xs-12 col-12">
                {!!$fecha!!}
            </div>
            <div class="col-lg-6 col-md-12 col-xs-12 col-12 text-right">
                <div class="btn-group">
                    <div class="form-group">
                        <select class="custom-select" id="fecha">
                        <option value="1" @if($date == 1)selected @endif>Hoy</option>
                        <option value="2" @if($date == 2)selected @endif>Mes actual</option>
                        <option value="3" @if($date == 3)selected @endif>Año actual</option>
                    </select>
                    </div>
                    <div class="form-group ml-2" >
                        <select class="custom-select"  id="pais">
                        <option value="1" @if($country == 1)selected @endif>El Salvador</option>
                        <option value="2" @if($country == 2)selected @endif>Guatemala</option>
                        <option value="4" @if($country == 4)selected @endif>Honduras</option>
                        <option value="6" @if($country == 6)selected @endif>Nicaragua</option>
                        <option value="3" @if($country == 3)selected @endif>Costa Rica</option>
                        <option value="5" @if($country == 5)selected @endif>Panama</option>
                        </select>
                    </div>
                    <div class="form-group ml-2">
                        <button type="button" class="btn btn-secondary " data-toggle="modal" data-target="#graficoModal">
                            Ir a fecha
                          </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if(isset($masvistas))
                @if(count($menosvistas)>0 || count($masvistas)>0)
                <div id="container"></div>
                <hr class="bg-primary">
                <div id="containerdos" class="mt-4"></div>
                @else
                    <p class="text-center">
                        No se encontro ningun resultado
                    </p>
                @endif
            @elseif(isset($masvistasUno)  || isset($masvistasDos))
                @if(count($masvistasUno) <= count($masvistasDos) && count($masvistasDos) > 0)
                <div id="container"></div>
                <hr class="bg-primary">
                <div id="containerdos" class="mt-4"></div>
                @else
                    <p class="text-center">
                        No se encontro ningun resultado para comparar
                    </p>
                @endif
            @endif
        </div>
    </div>
</div>
@include('modalgrafico')
@endsection

@section('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
@if(isset($masvistas))
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', () =>{
         var datas = [];
         var datasmenos = [];
         var colors = ['#C95D03', '#FF7400', '#FF943A', '#FFA050', '#FFAE6A', '#FFBB82', '#FCC89D', '#FCD0AA', '#FCD9BC','#FFEAD8'];
         @foreach($menosvistas as $key => $menos)
             datasmenos.push({name: "{{$menos->pantalla}}", data:{{'['.$menos->vistas.']'}}, color: colors['{{$key}}']});
         @endforeach
 
         @foreach($masvistas as $key => $mas)
             datas.push({name: "{{$mas->pantalla}}", data:{{'['.$mas->vistas.']'}}, color: colors['{{$key}}']});
         @endforeach
 
         $('#container').highcharts({
            
             chart: {
             type: 'column'
         },
         title: {
             text: 'Pantallas más vistas'
         },
         xAxis: {
             categories: [
                 'PANTALLAS'
             ]
         },
         legend: {
             layout: 'vertical',
             align: 'right',
             verticalAlign: 'middle'
         },
         colorAxis: [{}, {
         minColor: '#434348',
         maxColor: '#e6ebf5'
     }],
         yAxis: {
             title: {
                 text: 'Numero de vistas'
             },
             plotLines: [{
                         value: 0,
                         width: 1,
                         color: '#145589'
                     }]
            
         },
            series: datas,
            responsive: {
                 rules: [{
                     condition: {
                         maxWidth: 500
                     },
                     chartOptions: {
                         legend: {
                             layout: 'horizontal',
                             align: 'center',
                             verticalAlign: 'bottom'
                         }
                     }
                 }]
             }
        });
        
 
 
        $('#containerdos').highcharts({
            
            chart: {
            type: 'column'
        },
        title: {
            text: 'Pantallas menos vistas'
        },
        xAxis: {
            categories: [
                'PANTALLAS'
            ]
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        colorAxis: [{}, {
             minColor: '#434348',
             maxColor: '#e6ebf5'
         }],
        yAxis: {
            title: {
                text: 'Numero de vistas'
            },
            plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#145589'
                    }]
           
        },
           series: datasmenos,
           responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }
       });
    })
 </script>
@elseif($masvistasDos && count($masvistasDos) >= count($masvistasUno) && count($masvistasDos) > 0)
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', () =>{
         var datasmas = [];
         var datasmasDos = [];
         var unionMasarray = [];
         var datasmenos = [];
         var datasmenosDos = [];
         var unionMenosArray = [];
         var colorsdos = ['#444342','#5B5B5A','#6D6B69','#7B7977','#93908C','#ABA8A6','#BFBBB8','#D4D1CF','#DDD9D6','#E5E2DF'];
         var colors = ['#C95D03', '#FF7400', '#FF943A', '#FFA050', '#FFAE6A', '#FFBB82', '#FCC89D', '#FCD0AA', '#FCD9BC','#FFEAD8'];

         @foreach($masvistasUno as $key => $masuno)
             datasmas.push({name: "{{$masuno->pantalla}}", data:{{'['.$masuno->vistas.']'}}, color: colorsdos['{{$key}}']});
         @endforeach
 
         @foreach($masvistasDos as $key => $mas)
             datasmasDos.push({name: "{{$mas->pantalla}}", data:{{'['.$mas->vistas.']'}}, color: colors['{{$key}}']});
         @endforeach

         @foreach($menosvistasUno as $key => $menos)
            datasmenos.push({name: "{{$menos->pantalla}}", data:{{'['.$menos->vistas.']'}}, color: colorsdos['{{$key}}']});
         @endforeach

         @foreach($menosvistasDos as $key => $menos)
            datasmenosDos.push({name: "{{$menos->pantalla}}", data:{{'['.$menos->vistas.']'}}, color: colors['{{$key}}']});
         @endforeach

        for(var i = 0; i < datasmasDos.length; i++){
            unionMasarray.push(datasmasDos[i],datasmas[i]);
        }

        for(var j = 0; j < datasmenosDos.length; j++){
            unionMenosArray.push(datasmenos[j],datasmenosDos[j]);
        }

         $('#container').highcharts({
            
             chart: {
             type: 'column'
         },
         title: {
             text: 'Pantallas más vistas'
         },
         xAxis: {
             categories: ['Pantallas']
         },
         legend: {
             layout: 'vertical',
             align: 'right',
             verticalAlign: 'middle'
         },
         colorAxis: [{}, {
         minColor: '#434348',
         maxColor: '#e6ebf5'
     }],
         yAxis: {
             title: {
                 text: 'Numero de vistas'
             },
             plotLines: [{
                         value: 0,
                         width: 1,
                         color: '#145589'
                     }]
            
         },
            series: unionMasarray,
            responsive: {
                 rules: [{
                     condition: {
                         maxWidth: 500
                     },
                     chartOptions: {
                         legend: {
                             layout: 'horizontal',
                             align: 'center',
                             verticalAlign: 'bottom'
                         }
                     }
                 }]
             }
        });
 
        $('#containerdos').highcharts({
            
            chart: {
            type: 'column',
        },
        title: {
            text: 'Pantallas menos vistas'
        },
        xAxis: {
            categories: ['Pantallas']
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        colorAxis: [{}, {
            minColor: '#434348',
            maxColor: '#e6ebf5'
        }],
        yAxis: {
            title: {
                text: 'Numero de vistas'
            },
            plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#145589'
                    }]
        },
           series: unionMenosArray,
           responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }
       });
    });
 </script>
@endif

<script type="text/javascript">
$("#fecha").on("change", function(){
    var date = this.value;
    var pais = $("#pais").val();
    
    if(date == 1){
        window.location = "/mediacam/vistas/"+date+"/"+pais;
    }else if(date == 2){
        window.location = "/mediacam/vistas/month/"+date+"/"+pais;
    }else{
        window.location = "/mediacam/vistas/year/"+date+"/"+pais;
    }
});
 
$("#pais").on("change", function(){
    var date = $("#fecha").val();
    var pais = this.value;

    if(date == 1){
        window.location = "/mediacam/vistas/"+date+"/"+pais;
    }else if(date == 2){
        window.location = "/mediacam/vistas/month/"+date+"/"+pais;
    }else{
        window.location = "/mediacam/vistas/year/"+date+"/"+pais;
    }
});
</script>
@endsection



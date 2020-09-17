@extends('adminlte::page')

@section('title', "Productos")

@section('content_header')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="/admin/js/products_presentations.js"></script>

@stop

@section('content')

<div class="box">
    <div class="box-header">
        <h3 class="box-title">Ofertas</h3>
        <br>
        <button type="button" onclick="location.href='/admin/products/offerSelected/'+orderProducts" class="btn btn-success">Aplicar</button>
    </div>
    <br>
    <div class="box-body no-padding">
        <table class="table table-condensed">
            <tbody>
                <tr>
                    <th style="width:5">Orden</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Marca</th>
                    <th>Precio</th>
                    <th>Presentación en oferta</th>
                </tr>
                @foreach ( $offerProducts as $offerProduct )    
                <tr>
                    <td style="width:5"><input type="checkbox" onclick="selectProduct(this);" value="{{$offerProduct->id}}" name="order" 
                    @foreach ( $offerSelected as $offerSel ) @if ( $offerProduct->id == $offerSel->product_id ) checked @endif @endforeach/><span id="orderNum{{$offerProduct->id}}"></span></td>
                    <td>{{ $offerProduct->name }}</td>
                    <td>{{ $offerProduct->category->name }}</td>
                    <td>{{ $offerProduct->brand->name }}</td>
                    <td>{{ $offerProduct->price }}</td>  
                    <td>@foreach ( $offerProduct->presentations as $offerPresentation )
                            @if ( $offerPresentation['offer'] == 1 )
                                {{ $offerPresentation['presentation'] }}
                            @endif 
                        @endforeach</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="">
@stop

@section('js')

<script>

let orderProducts = [];

function selectProduct(e)
{
    let num = 0;
    if (e.checked){
        if (orderProducts.length > 3){
            event.preventDefault();
            Swal.fire({
            text: "Las ofertas en el sitio no pueden ser más de 4.",
            confirmButtonText: "Ok", 
            closeOnConfirm: true,
          })
        } else {
            orderProducts.push(e.value);
            orderProducts.forEach(function(a, i){
                $("#orderNum" + a).html(i + 1);
            });           
        }
    } else {
        orderProducts = orderProducts.filter(elem => elem != e.value);
        $("#orderNum" + e.value).html('');
        orderProducts.forEach(function(a, i){
            $("#orderNum" + a).html(i + 1);
        });
    }  
} 

</script>

@stop
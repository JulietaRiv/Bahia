@extends('adminlte::page')

@section('title', "Productos")

@section('content_header')
   
@stop

@section('content')

    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Producto:  {{ $product->name }}</h3>
            </div>
            <br>
            <div class="box-body">
                <table class="table table-bordered">
                    <tbody>
                        <ul>
                            @if ( $product->photo != null )
                            <li><img title="" width="150" height="150" alt="{{$product->photo}}" src="/storage/images/products/{{$product->photo}}"></a></li>
                            @else
                            <li><img title="" width="150" height="150" alt="" src="/site/images/logo-roble.jpg"></a></li>
                            @endif
                            <li>Categoría: {{ $product->category->name }}</li>
                            <li>Marca: {{ $product->brand->name }}</li>
                            <li>Precio: $ {{ $product->price }}</li>
                            <li>Precio promo: $ {{ $product->promo_price }}</li>
                            <li>Descripción: {{ $product->description }}</li>
                            <li>Stock: {{ $product->stock  == 1 ? 'Si' : 'No' }}</li>
                            <li>Oferta: {{ $product->offer  == 1 ? 'Si' : 'No' }}</li>
                            <li>Destacado: {{ $product->highlighted  == 1 ? 'Si' : 'No' }}</li>
                            <li>Sin Tacc: {{ $product->celiacs  == 1 ? 'Si' : 'No' }}</li>
                            <li>Orgánico: {{ $product->organic  == 1 ? 'Si' : 'No' }}</li>
                            <li>Agroecológico: {{ $product->agroecological  == 1 ? 'Si' : 'No' }}</li>
                            <li>Vegano: {{ $product->vegan  == 1 ? 'Si' : 'No' }}</li>
                            <li>Presentaciones: </li>
                        </ul>
                        <table border='1' style='width:90%'>
                            <thead>
                                <tr>
                                    <th>Default</th>
                                    <th>Presentación</th>
                                    <th>Precio</th>
                                    <th>Precio Promo</th>
                                    <th>Es oferta</th>
                                    <th>Es destacado</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ( $product->presentations as $pres )
                                <tr>
                                    <td><input ${ checked } type="radio" name="default"/></td>
                                    <td>{{ $pres['presentation'] }}</td>
                                    <td>{{ $pres['price'] }}</td>
                                    <td>{{ $pres['promo_price'] }}</td>
                                    <td>{{ $pres['offer'] }}</td>
                                    <td>{{ $pres['highlighted'] }}</td>
                                    <td>{{ $pres['stock'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <br>
                        <br>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
@stop

@section('css')
    <link rel="stylesheet" href="">
@stop

@section('js')
    <script> </script>
@stop
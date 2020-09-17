@extends('adminlte::page')

@section('title', "Productos")

@section('content_header')
    
@stop

@section('content')
    
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Productos</h3>
            <br>
            <h4><a href="/admin/products/add"><span class="badge bg-green">Agregar +</span></a></h4>
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if($errors->any())
                <h4>{{$errors->first()}}</h4>
            @endif
            <form style="position:absolute; right:5px;" id="searchForm" action="{{Route('products')}}" method="get">
                <input value="{{$search ?? ''}}" type="search" name="search" placeholder="Buscar...">
                <button type="submit"  class="btn btn-default search" aria-label="Left Align">
                    <i class="fa fa-search" aria-hidden="true"> </i>
                </button>
				<div class="clearfix"></div>
			</form>
        </div>  
        <br>
        <br>
        <div class="box-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Marca</th>
                        <th>Precio</th>
                        <th>Orgánico</th>
                        <th>Sin Tacc</th>
                        <th>Agro ecológico</th>
                        <th>Vegano</th>
                        <th>Stock</th>
                        <th>Ofertas</th>
                        <th>Destacados</th>
                        <th style="width: 10%">Acción</th>
                    </tr>
                    @foreach ( $products as $product )
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->brand->name }}</td>
                        <td>{{ $product->price }}</td>   
                        <td>{{ $product->organic  == 1 ? 'Si' : 'No' }}</td>
                        <td>{{ $product->celiacs  == 1 ? 'Si' : 'No' }}</td>
                        <td>{{ $product->agroecological  == 1 ? 'Si' : 'No' }}</td>
                        <td>{{ $product->vegan  == 1 ? 'Si' : 'No' }}</td>
                        <td>{{ $product->stock  == 1 ? 'Si' : 'No' }}</td>
                        <td>{{ $product->offer  == 1 ? 'Si' : 'No' }}</td>
                        <td>{{ $product->highlighted  == 1 ? 'Si' : 'No' }}</td>
                        <td><a href="/admin/products/edit/{{ $product->id }}"><span class="badge bg-green">Editar</span></a>
                        <a href="/admin/products/detail/{{ $product->id }}"><span class="badge bg-blue">Ver</span></a>
                        <a href="/admin/products/delete/{{ $product->id }}"><span class="badge bg-red">Eliminar</span></a></td>
                    </tr>
                    @endforeach
                </tbody>           
            </table>
        </div>
        <div class="box-footer clearfix">
            {!! $links !!}
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="">
@stop

@section('js')
    <script> </script>
@stop

   
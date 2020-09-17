@extends('adminlte::page')

@section('title', "Categories")

@section('content_header')
    
@stop

@section('content')
    
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Categorías</h3>
            <br>
            <h4><a href="/admin/categories/add"><span class="badge bg-green">Agregar +</span></a></h4>
        </div>  
            <div class="box-body">
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <h4>{{$errors->first()}}</h4>
                @endif
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Nombre</th>
                            <th style="width: 20%">Acción</th>
                        </tr>
                        @foreach ( $categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>    
                            <td><a href="/admin/categories/edit/{{ $category->id }}"><span class="badge bg-green">Editar</span></a>
                            <a href="/admin/categories/detail/{{ $category->id }}"><span class="badge bg-blue">Ver</span></a>
                            <a href="/admin/categories/delete/{{ $category->id }}"><span class="badge bg-red">Eliminar</span></a></td>
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

@stop

@section('js')
    <script> </script>
@stop

   
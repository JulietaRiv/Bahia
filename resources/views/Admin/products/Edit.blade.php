@extends('adminlte::page')

@section('title', "Productos")

@section('content_header')
  
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="/admin/js/products_presentations.js"></script>

@stop

@section('content')

<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Editar producto</h3>
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
          <form id="prodForm" method="post" action="{{Route('productsUpdate')}}" enctype="multipart/form-data" name="prodForm" role="form">
            <input type="hidden" name="_token" value="">      
            @csrf            
            <label>Nombre</label>
              <input id="name" class="form-control input-lg" value="{{$product->name}}" name="name" type="text">
              <br>
              <div class="form-group">
                <label>Categoría</label>
                <select name="category_id" class="form-control">
                @foreach ( $categories as $category )         
                  <option value="{{$category->id}}" @if ( $category->id == $product->category_id )  selected @endif>{{ $category->name }}</option>      
                @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Marca</label>
                <select name="brand_id" class="form-control">
                  @foreach ( $brands as $brand )
                  <option value="{{$brand->id}}" @if ( $brand->id == $product->brand_id ) selected @endif>{{ $brand->name }}</option>
                  @endforeach
                </select>
              </div>
              <br>
              <div class="form-group">
                <label for="InputFile">Foto</label>
                <input id="image" name="image" type="file" value="{{$product->photo}}">
                <p style="display:inline-block;">
                @if ($product->photo != null) /   
                  <img style="width:200px;"  src="/storage/images/products/{{$product->photo}}">
                @endif</p>  
                &nbsp<a href="{{Route('productsDeleteImage', $product->id)}}"><img style="width:20px;" src="/site/images/close_1.png"></a>  
              </div>
              <label>Descripción</label>
                <input id="description" name="description" class="form-control input-lg" type="text" value="{{$product->description}}">
                <br>
              <div class="checkbox">
                <label>
                  <input value="1" id="celiacs" name="celiacs" type="checkbox" @if( $product->celiacs == "1" ) checked @endif> Sin Tacc
                </label>
              </div>
              <div class="checkbox">
                <label>
                  <input value="1" id="organic" name="organic" type="checkbox" @if( $product->organic == "1" ) checked @endif> Orgánico
                </label>
              </div>
              <div class="checkbox">
                <label>
                  <input value="1" id="agroecological" name="agroecological" type="checkbox" @if( $product->agroecological == "1" ) checked @endif> Agroecológico
                </label>
              </div>
              <div class="checkbox">
                <label>
                  <input value="1" id="vegan" name="vegan" type="checkbox" @if( $product->vegan == "1" ) checked @endif> Vegano
                </label>
              </div>
              <br>
              <button onclick="showPresForm(false); return false;" id="cargarPres" name="cargarPres"  type="button" class="btn btn-primary">Cargar presentaciones</button>
              <br>
              <hr>
              <div id="presentationsAdded" class="box">        
                <div class="box-header with-border">
                  <h3 class="box-title">Presentaciones</h3><div><span class="badge bg-green"></span></div>
                  <br>
                </div>
                <div id="presentationContent" class="box-body"></div>           
              </div>
              <br>
              <button type="submit" class="btn btn-success">Guardar</button>
              <br>
              <input type="hidden" id="productId" name="productId" value="{{$product->id}}"/>
              <input type="hidden" id="presentations" name="presentations" value=""/>      
            </form>
            <br>
            <br>
        </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="">
@stop

@section('js')
    <script>

    @if ($product->presentations != '')
    let presentations = {!! json_encode($product->presentations) !!};
    @else 
    let presentations = [];
    @endif

    </script>
@stop
@extends('adminlte::page')

@section('title', "Productos")

@section('content_header')
 
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script src="/admin/js/products_presentations.js"></script>
@stop

@section('content')

<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Nuevo producto</h3>
    </div>
    <br>
        <div class="box-body">
          @if(session()->has('success'))
              <div class="alert alert-success">
                  {{ session()->get('success') }}
              </div>
          @endif
          @if($errors->any())
              <h4>{{$errors->first()}}</h4>
          @endif
            <div id="totalForm">
              <form id="prodForm" method="post" action="{{route('productsStore')}}" enctype="multipart/form-data" name="prodForm" role="form">
              @csrf            
                <label>Nombre</label>
                  <input id="productName" class="form-control input-lg" value="{{ old('name') }}" name="name" type="text">
                  <br>
                <div class="form-group">
                  <label>Categoría</label>
                  <select id="category_id" name="category_id" class="form-control">
                      <option value="" >- Seleccionar -</option>        
                    @foreach ( $categories as $category )         
                      <option value="{{$category->id}}" @if ( old('category_id') ==  $category->id ) selected @endif>{{ $category->name }}</option>      
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Marca</label>
                  <select id="barnd_id" name="brand_id" class="form-control">
                      <option value="" >- Seleccionar -</option>
                    @foreach ( $brands as $brand )
                      <option value="{{$brand->id}}" @if ( old('brand_id') == $brand->id ) selected @endif>{{$brand->name}}</option>
                    @endforeach
                  </select>
                </div>
                <br>
                <div class="form-group">
                  <label for="InputFile">Foto</label>
                  <input id="image" name="image" type="file" value="">
                </div>
                <label>Descripción</label>
                  <input id="description" name="description" class="form-control input-lg" type="text" value="{{ old('description') }}">
                  <br>
                <div class="checkbox">
                  <label>
                    <input id="celiacs" name="celiacs" value="1" type="checkbox" @if (old('celiacs')) checked @endif> Sin Tacc
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input id="organic" name="organic" type="checkbox" value="1" @if (old('organic')) checked @endif> Orgánico
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input id="agroecological" name="agroecological" type="checkbox" value="1" @if (old('agroecological')) checked @endif> Agroecológico
                  </label>
                </div>
                <div class="checkbox">
                  <label>
                    <input id="vegan" name="vegan" type="checkbox" value="1" @if (old('vegan')) checked @endif> Vegano
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
                  <input type="hidden" id="presentations" name="presentations" value="">
              </form>
            </div>
            <br>       
        </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="">
@stop

@section('js')

<script>

  @if (old('presentations') != '')
  let presentations = {!!old('presentations')!!};
  @else 
  let presentations = [];
  @endif

</script>

@stop
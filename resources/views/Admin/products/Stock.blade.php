@extends('adminlte::page')

@section('title', "Productos")

@section('content_header')

<script src="/admin/js/products_presentations.js"></script>

@stop

@section('content')

<div class="box">
    <div class="box-header">
        <h3 class="box-title">Stock</h3>
        <br>
    </div>
    <br>
    <div class="form-group">
        <label>Seleccionar marca</label>
        <select name="brand_id" id="brand_id" class="form-control">
            @foreach ($brands as $brand)
            <option value="{{$brand->id}}">{{$brand->name}}</option>
            @endforeach
        </select>
    </div>
    <div id="productResult">
    </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="">
@stop

@section('js')
<script>

$( "#brand_id" ).change(function()   {
        $.ajax({
            url: "{{Route('productsStockPerBrand')}}",
            data : {brand_id : $(this).val()}
        }).done(function(response) {
            $('#productResult').html(response);
        });
    });

</script>
@stop
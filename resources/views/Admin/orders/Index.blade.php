@extends('adminlte::page')

@section('title', "Orders")

@section('content_header')
    
@stop

@section('content')
    
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Pedidos</h3>
            <br>
        </div>
        <br>
        <form id="searchForm" action="{{Route('orders')}}" method="get">
            <table style="width:100%;">
                <tbody>
                    <tr>
                        <td><select name="orderStatus" style="display:inline;" class="form-control">                                   
                                <option>Todos</option>
                                <option value="pendiente" @if ($orderStatus == "pendiente" ) selected @endif>Pendientes</option>
                                <option value="armado" @if ($orderStatus == "armado" ) selected @endif>Armados</option>
                                <option value="entregado" @if ($orderStatus == "entregado" ) selected @endif>Entregados</option>
                            </select>
                        </td>
                        <td><input name="orderNum" value="{{$orderNum}}" style="display:inline;" type="text" class="form-control" placeholder="n° de pedido ..."></td>
                        <td><input name="orderText" value="{{$orderText}}" style="display:inline;" type="text" class="form-control" placeholder="buscar ..."></td>
                        <td><button type="submit" class="btn-warning" style="display:inline;"><i class="fa fa-search" aria-hidden="true"> </i>Buscar</button></td>
                    </tr>
                </tbody>
            </table>
        </form>
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
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>N°</th>
                        <th>Cliente</th>
                        <th>Cel</th>
                        <th>Dirección</th>
                        <th>Medio de Pago</th>
                        <th>Fecha/hs</th>
                        <th>Estado</th>
                        <th style="width: 20%">Acción</th>
                    </tr>          
                    @foreach ( $orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>    
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->cel }}</td>
                        <td>{{ $order->address }}</td>    
                        <td>{{ $order->payment_method }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->status }}</td>
                        <td>
                            @if ( $order->status == "armado")
                            <a href="/admin/orders/delivery/{{ $order->id }}"><span class="badge bg-purple">Entregado</span></a>
                            @endif
                            <a @if ( $order->status != "pendiente" ) href="" @else href="/admin/orders/edit/{{ $order->id }}" @endif><span class="badge bg-green">Editar</span></a>
                            <a href="/admin/orders/detail/{{ $order->id }}"><span class="badge bg-blue">Ver</span></a>
                            <a href="/admin/orders/detail/{{ $order->id }}"><span class="badge bg-orange">Descargar</span></a>
                            <a href="/admin/orders/delete/{{ $order->id }}"><span class="badge bg-red">Eliminar</span></a>
                        </td>
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

   

<div class="col-md-12">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Detalle del pedido n° {{$order->id}}</h3>
        </div>
        <br>
        <h5 style="display:inline-block;">Estado: <span style="color:red;">{{ $order->status }}</span></h5>
        <br>
        <div class="box-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->address }}</td>
                    </tr>
                    <tr>
                        <td>{{ $order->cel }}</td>
                        <td>{{ $order->payment_method }}</td>
                    </tr>
                    <tr>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->comment }}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table bordered">
                <thead style="text-align:center;">
                    <tr>
                        <th style="text-align:left;">Items</th>
                        <th>Unidades</th>
                        <th>Precio por unidad</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $total = 0;
                    $unidades = 0;
                    @endphp
                    @foreach ( $order->items as $item )
                    @php
                    $total += $item['price'];
                    $unidades += $item['quantity'];
                    @endphp
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td style="text-align:center;">{{ $item['quantity'] }}</td>
                        <td style="text-align:center;">${{ $item['unit_price'] }}</td>
                        <td style="text-align:center;">${{ $item['price'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td>Precio final</td>
                        <td style="text-align:center;">{{ $unidades }}</td>
                        <td></td>
                        <td style="text-align:center; font-weight:bold;">${{ $total }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

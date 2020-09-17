
    <div class="box">
        <br>
        <div class="box-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Marca</th>
                        <th>Presentación</th>
                        <th>Precio</th>
                        <th style="width: 10%">Acción</th>
                    </tr>
                    @if ( $products != null )
                    @foreach ( $products as $product )
                    @foreach ( $product->presentations as $presentation )
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->brand->name }}</td>
                        <td>{{ $presentation['presentation'] }}</td>
                        <td>{{ $presentation['price'] }}</td>
                        <td><a type="button" onclick="addItem({{$product->id}},'{{$product->name}}','{{$presentation['presentation']}}',{{$presentation['price']}});"><span class="badge bg-orange">Agregar</span></a></td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>           
            </table>
        </div>
        @endif
    </div>



   
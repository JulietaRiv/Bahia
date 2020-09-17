    <div class="box-body no-padding">
        <table class="table table-condensed">
            <tbody>
                <tr>
                    <th>Nombre</th>
                    <th>Presentación</th>
                    <th>Stock</th>
                    <th>Estado</th>
                </tr>
                @foreach ( $nuevoProducts as $presentation )
                <tr>
                    <td>{{ $presentation['name'] }}</td>
                    <td>{{ $presentation['presentation'] }}</td>
                    <td>{{ $presentation['stock'] }}</td>
                    <td>@if ( $presentation['stock'] < 5 )<span class="badge bg-red">< 5</span>
                    @elseif ( $presentation['stock'] <= 10 ) <span class="badge bg-yellow">5 - 10</span>
                    @else <span class="badge bg-green">> 10</span>@endif</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

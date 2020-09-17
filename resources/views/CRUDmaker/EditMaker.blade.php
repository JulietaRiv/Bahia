@@extends('adminlte::page')

@@section('title', "{{ $data['pluralUpperName'] }}")

@@section('content_header')
    
@@stop

@@section('content')

<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $data['pluralUpperName'] }}</h3>
    </div>
        <div class="box-body">
            <form  role="form">
            @csrf
            </form>
        </div>
</div>

@@stop

@@section('css')
    <link rel="stylesheet" href="">
@@stop

@@section('js')
    <script> </script>
@@stop
@@extends('adminlte::page')

@@section('title', "{{ $data['pluralUpperName'] }}")

@@section('content_header')
    
@@stop

@@section('content')
    
    <div class="box">
        <div class="box-header with-border">
        <h3 class="box-title">{{ $data['pluralUpperName'] }}</h3>
        <h4><span class="badge bg-green">Add +</span></h4>
        </div>  
            <div class="box-body">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th style="width: 20%"></th>
                    <th></th>
                    <th></th>
                    <th style="width: 15%">Action</th>
                </tr>
                
                <tr>
                    <td>sample</td>
                    <td>sample</td>
                    <td>sample</td>           
                    <td><span class="badge bg-green">Edit</span>
                    <span class="badge bg-blue">View</span>
                    <span class="badge bg-red">Delete</span></td>
                </tr>
                </tbody>
                
            </table>
            </div>
            <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin pull-right">
                <li><a href="#">«</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">»</a></li>
            </ul>
            </div>
    </div>

@@stop

@@section('css')
    <link rel="stylesheet" href="">
@@stop

@@section('js')
    <script> </script>
@@stop

   
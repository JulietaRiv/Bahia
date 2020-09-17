<?php
echo "<?php\n";
?>

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App;
use App\{{ $data['pluralUpperName'] }};
use App\Http\Controllers\Controller;

class {{ $data['pluralUpperName'] }}Controller extends Controller
{
    public function index()
    {
        ${{ $data['pluralName'] }} = '';
        return view ("Admin/{{ $data['pluralName'] }}/Index", ["{{ $data['pluralName'] }}" => ${{ $data['pluralName'] }}]);
    }

    public function create()
    {
        return view ("Admin/{{ $data['pluralName'] }}/Form");
    }

    public function store(Request $request)
    {
        ${{ $data['name'] }} = new {{ $data['upperName'] }}();
        ${{ $data['name'] }}->save();
        return redirect()->route("{{ $data['upperName'] }}");
    }

    public function detail ($id)
    {
        ${{ $data['name'] }} = {{ $data['upperName'] }}::where('id', '=', $id)->first();
        return view ("Admin/{{ $data['pluralName'] }}/Detail", ["{{ $data['name'] }}" => ${{ $data['name'] }}] );
    }

    public function delete ($id)
    {
        if (${{ $data['name'] }} = {{ $data['upperName'] }}::where('id', '=', $id)->first()){
            ${{ $data['name'] }}->delete();
            return redirect()->route("{{ $data['pluralName'] }}")->with('success','Excelente, registro guardado!');
        } else {
            return redirect()->route("{{ $data['pluralName'] }}")->with('errors','Oops ocurrió un error!');
        }  
    }

    public function edit($id)
    {
        ${{ $data['name'] }} = {{ $data['upperName'] }}::where('id', '=', $id)->first();
        return view ("Admin/{{ $data['pluralName'] }}/Edit", ['{{ $data['name'] }}' => ${{ $data['name'] }}]);        
    }

    public function update (Request $request)
    {
        ${{ $data['name'] }} = Category::where('id', '=', $request->id)->first();
        ${{ $data['name'] }}->update();
        return redirect()->route("{{ $data['pluralName'] }}")->with('success','Excelente, registro guardado!');
    }

}
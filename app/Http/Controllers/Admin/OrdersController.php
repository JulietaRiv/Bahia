<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;
use App\Notifications\HelloNotification;

class OrdersController extends Controller
{

    public function index(Request $request)
    {      
        $orders = Order::query()->orderBy('id', 'desc');   
        $appends = [];
        if ($request->orderStatus != 'Todos' && $request->orderStatus != null){
            $orders = $orders->where('status', '=', $request->orderStatus);
            $appends['orderStatus'] = $request->orderStatus;
        } 
        if ($request->orderNum != null){
            $orders = $orders->where('id', '=', $request->orderNum);
            $appends['orderNum'] = $request->orderNum;
        } 
        if ($request->orderText != null){
            $orders = $orders->search($request->orderText);
            $appends['orderText'] = $request->orderText;
        }
        $orders = $orders->paginate(30);
        if (count($appends) > 0){
            $links = $orders->appends($appends)->links();
        } else {
            $links = $orders->links();
        }
        return view ("Admin/orders/Index", [
            "orders" => $orders, 
            'links'=>$links, 
            'orderStatus'=> $request->orderStatus,
            'orderNum' => $request->orderNum,
            'orderText' => $request->orderText,
        ]);
    }

    public function delete($id)
    {
        if ($order = Order::where('id', $id)->first()){       
            $order->delete();
            return redirect()->route("orders")->with('success','Excelente, registro guardado!');
        } else {
            return redirect()->route("orders")->with('errors','Oops ocurrió un error!');
        }  
    }

    public function detail(Request $request, $id)
    {
        $order = Order::where('id', $id)->first();
        $view = ($request->print == false) ? "Admin/orders/Detail" : "Admin/orders/Print";
        return view ($view, ["order" => $order]);
    }

    public function edit($id)
    {
        $order = Order::where('id', $id)->first();
        return view ("Admin/orders/Edit", ["order" => $order]);
    }

    public function update(Request $request)
    {   
        $order = Order::where('id', $request->input('orderId'))->first();
        $order->name = $request->input('name2');
        $order->address = $request->input('address2');
        $order->cel = $request->input('cel2');
        $order->payment_method = $request->input('payment_method2');
        $order->comment = $request->input('message2');
        $order->status =  (data_get($request, 'armado', 0) == 1) ? "armado" : "pendiente";
        $items = json_decode($request->input('itemsList'), true);
        foreach ($items as $item){
            $item['product_id'] = $item['product_id'] * 1;
            $item['quantity'] = $item['quantity'] * 1;
            $item['unit_price'] = $item['unit_price'] * 1;
            $item['price'] = $item['price'] * 1;
        }
        $order->items = $items;
        $order->total_units = $request->input('totalUnits');
        $order->total_price = $request->input('totalPrice');
        $order->save();
        if ($order->status == "armado"){
                foreach ($order->items as $item) {
                $product = Product::where('id', $item['product_id'])->first();
                $stock = 0;
                $presentations = $product->presentations;
                foreach ($presentations as $i => $presentation) {
                    if ($presentation['presentation'] == $item['presentation']) {
                        $presentations[$i]['stock'] = $presentations[$i]['stock'] - $item['quantity'];
                    }
                    $stock += $presentation['stock'];
                }
                $product->presentations = $presentations;
                $product->stock = ($stock != 0) ? 1 : 0;
                $product->save();
            }
        }
        return redirect()->route("orders")->with('success', 'Excelente, registro guardado!');
    }

    public function addProduct($order_id)
    {
        return view('Admin/orders/ProductOrderSearch', ['order_id'=>$order_id]);
    }

    public function delivery($id)
    {
        $order = Order::where('id', $id)->first();
        $order->status = "entregado";
        $order->save();
        return redirect()->route("orders")->with('success', 'Excelente, registro actualizado!');
    }

    public function notificarOrden(Request $request)
    {
        $request->user()->notify(new HelloNotification);
        return response()->json('Notification sent.', 201);
    }

}
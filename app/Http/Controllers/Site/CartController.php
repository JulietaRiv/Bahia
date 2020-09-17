<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Product;
use App\Order;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Http\Request;


class CartController extends Controller
{

    public function checkout(Request $request)
    {
        $price = 0;
        $itemsList = [];
        $itemsQuantity = 0;
        if ($request->isMethod('post')) {
            $itemsKeys = array_keys($request->all());
            $itemsQuantity = (count($itemsKeys) - 8) / 5;
            for ($i = 1; $i <= $itemsQuantity; $i++){
                $product = Product::where('id', $request->{'shipping_' . $i})->first();
                foreach ($product->presentations as $presentation) {
                    if ($presentation['presentation'] == $request->{'shipping2_' . $i}) {
                        $price = $presentation['price'];
                    }
                }
                $itemsList[$i - 1] = [
                    'product_id' => $request->{'shipping_' . $i},
                    'name' => $request->{'item_name_' . $i},
                    'presentation' => $request->{'shipping2_' . $i},
                    'quantity' => $request->{'quantity_' . $i},
                    'unit_price' => $price,
                    'price' => $request->{'quantity_' . $i} * $price,
                ];
            } 
            $request->session()->put('itemsList', $itemsList);
        } else {
            $itemsList = $request->session()->get('itemsList');
        }
        return view('Site/checkoutForm', ['itemsList' => $itemsList]);
    }

    public function sendOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'cel' => 'required',
            'payment_method' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $order = new Order();
            $order->name = $request->input('name');
            $order->address = $request->input('address');
            $order->cel = $request->input('cel');
            $order->payment_method = $request->input('payment_method');
            $order->comment = $request->input('message');
            $items = $request->session()->get('itemsList');
            foreach ($items as $item){
                $item['product_id'] = $item['product_id'] * 1;
                $item['quantity'] = $item['quantity'] * 1;
                $item['unit_price'] = $item['unit_price'] * 1;
                $item['price'] = $item['price'] * 1;
            }
            $order->items = $items;
            $order->save();
            return redirect()->route('index')->with('success', 'gracias');
        }
    }
}

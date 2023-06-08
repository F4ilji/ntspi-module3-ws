<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return OrderResource::collection(auth()->user()->orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'products' => 'array|required|',
            'products.*' => 'integer',
        ]);

        $order = Order::create([
            'user_id' => auth()->user()->id
        ]);
        $productsId = $data['products'];
        $order->products()->attach($productsId);

        return new OrderResource(Order::find($order->id));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'products' => 'array|required|',
            'products.*' => 'integer',
        ]);

        $order = Order::findOrFail($id);

        // Очищаем связи с продуктами
        $order->products()->detach();

        $productsId = $data['products'];
        $order->products()->attach($productsId);

        return new OrderResource($order);
    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        if (auth()->user()->id != $order->user_id) {
            return response(['message' => 'not exist'], 404);
        } else {

            return new OrderResource(Order::find($order->id));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    //public function cancelOrder(Request $request, Order $order)
    //{
    //    $data = $request->validate([
    //        'status' => 'integer|required|in:2',
    //    ]);
    //    $order = Order::find($order->id);
    //    if($order->status === 0) {
    //        $order->update($data);
    //        return response(['order' => new OrderResource($order)], 201);
    //    }
    //    return response(['message' => 'Access denied'], 403);
    //}


    public function destroy(Order $order)
    {
        if ($order->status === 0) {
            $order->delete();
            return response(['message' => 'Success'], 200);
        } else {
            return response(['message' => 'Access denied'], 403);
        }
    }
}

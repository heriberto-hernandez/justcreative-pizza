<?php

namespace App\Http\Controllers\API;

use App\Entities\Order;
use App\Entities\OrderPizza;
use Illuminate\Http\Request;
use App\Http\Resources\Order as OrderResources;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderPizza;
use App\Http\Resources\OrderPizza as OrderPizzaResources;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return OrderResources::collection( Order::all()  );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        $order = new Order();     
        $order->number_order = $request->number_order;
        $order->date = $request->date; 
        $order->total = $request->total; 
        $order->users_id = $request->users_id;
        $store = $order->save();

        if ($store) {
            return ['action' => $store, 'data' => $order];
        }else{
            return ['action' => $store, 'data' => NULL];;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new OrderResources(Order::where('number_order', $id)->first() );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = Order::where('number_order', $id)
          ->update(['total' =>  $request->total]);     

        if ($update) {
            return response( ['data' => trans('app.msg_ctrl.add_success') ] , 200)
                  ->header('Content-Type', 'text/plain');
        }else{
            return response( ['data' => trans('app.msg_ctrl.update_error') ] , 500)
                  ->header('Content-Type', 'text/plain');  
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function orderDetails($id)
    {
        return OrderPizzaResources::collection( OrderPizza::where('number_order', $id)->get()  );
    }

    public function removePizzaOrder($order, $pizza, $created)
    {
        $deletedRows = OrderPizza::where([
                                            ['number_order', '=', $order],
                                            ['pizzas_id', '=', $pizza],
                                            ['created_at', '=', $created],
                                        ])->delete();
        if ($deletedRows) {
            return response( ['data' => trans('app.msg_ctrl.delete_success') ] , 200)
                  ->header('Content-Type', 'text/plain');
        }else{
            return response( ['data' => trans('app.msg_ctrl.delete_error') ] , 500)
                  ->header('Content-Type', 'text/plain');  
        }
    }

    public function addPizzaOrder(StoreOrderPizza $request)
    {
        $order = new OrderPizza;
        $order->number_order   = $request->number_order;
        $order->pizzas_id      = $request->pizzas_id;
        $store = $order->save();
       
        if ($store) {
            return response( ['data' => trans('app.msg_ctrl.add_success') ] , 200)
                  ->header('Content-Type', 'text/plain');
        }else{
            return response( ['data' => trans('app.msg_ctrl.add_error') ] , 500)
                  ->header('Content-Type', 'text/plain');  
        }
    }
}

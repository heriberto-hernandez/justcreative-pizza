<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\OrderController;

class HomeController extends Controller
{
    private $order;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->order = new OrderController();
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function createOrder()
    {
        $users_id = Auth::id();
        $date = date('Y-m-d H:i');
        $number_order = date('YmdHis');

        $request = Request();
        $request->request->add(['number_order' => $number_order ]);
        $request->request->add(['date' => $date ]);
        $request->request->add(['total' => 0 ]);
        $request->request->add(['users_id' => $users_id ]);
        $data =  $this->order->store($request); 

        if ($data['action']) {
            return view('order.create', ['data' =>  $data['data']]);
        }else{
            return response( trans('app.add_error') , 500)
                  ->header('Content-Type', 'text/plain');  
        }
    }
    
    public function orderDetails($number_order)
    {
        $order = $this->order->show($number_order); 
        $pizza = $this->order->orderDetails($number_order); 
        return view('order.details', [ 'pizza' => $pizza, 'order' => $order]);
    }

    public function orderList()
    { 
        return view('order.list');
    }    
}

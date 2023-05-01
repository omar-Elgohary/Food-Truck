<?php
namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Without;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiResponseTrait;

class CustomerController extends Controller
{
    use ApiResponseTrait;

    public function myOrders(Request $request) // all orders where auth user
    {
        try{
            $orders = Order::where('customer_id', auth()->user()->id)->get();
            foreach($orders as $order){
                $order['customer'] = User::where('id', $order['customer_id'])->get();
                $order['seller'] = User::where('id', $order['seller_id'])->get();
                $order['product'] = Product::where('id', $order['product_id'])->get();
                $order['withouts'] = Without::where('id', $order['without_id'])->get();
            }
            
            return $this->returnData(200, 'Orders Returned Successfully', compact('orders'));
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(400, "Orders Returned Failed");
        }
    }
}

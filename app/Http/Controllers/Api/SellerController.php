<?php
namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiResponseTrait;

class SellerController extends Controller
{
    use ApiResponseTrait;
    public function myOrders()
    {
        try{
            $orders = Order::where('seller_id', auth()->user()->id)->get();
            foreach($orders as $order){
                $order['customer'] = User::where('id', $order['customer_id'])->get();
                $order['seller'] = User::where('id', $order['seller_id'])->get();
                $order['product'] = Product::where('id', $order['product_id'])->get();
            }
            return $this->returnData(200, 'Orders Returned Successfully', $orders);
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(400, "Orders Returned Failed");
        }
    }
}

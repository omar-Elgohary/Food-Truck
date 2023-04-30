<?php
namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiResponseTrait;

class OrderController extends Controller
{
    use ApiResponseTrait;

    public function makeOrder(Request $request, $seller_id)
    {
        try{
            $seller = User::find($seller_id);
            $order = Order::create([
                'customer_id' => auth()->user()->id,
                'seller_id' => $seller_id,
                'product_id' => $request->product_id
            ]);
            $order['customer'] = User::where('id', auth()->user()->id)->get();
            $order['seller'] = User::where('id', $request->seller_id)->get();
            $order['product'] = Product::where('id', $request->product_id)->get();
            return $this->returnData(201, 'Make Order Successfully', $order);
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(400, "Make Order Failed");
        }
        
    }






}

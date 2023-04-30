<?php
namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Section;
use App\Models\Without;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiResponseTrait;

class OrderController extends Controller
{
    use ApiResponseTrait;

    public function allOrders(Request $request)
    {
        try{
            $orders = Order::get();
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





    public function makeOrder(Request $request, $seller_id, $section_id)
    {
        try{
            $seller = User::find($seller_id);
            $section = Section::find($section_id);
            if(!$seller || $seller->type != 'seller' || !$section){
                return $this->returnError(400, "Seller or Section Not Found");
            }
            $without = implode(',', $request->without_id) ;

            if($request->product_id == null){
                return $this->returnError(400, "Product Not Found");
            }
            $order = Order::create([
                'customer_id' => auth()->user()->id,
                'seller_id' => $seller_id,
                'section_id' => $section_id,
                'product_id' => $request->product_id,
                'spicy' => $request->spicy,
                'without_id' => $without
            ]);
            $order['customer'] = User::where('id', auth()->user()->id)->get();
            $order['seller'] = User::where('id', $request->seller_id)->get();
            $order['product'] = Product::where('id', $request->product_id)->get();

            foreach(explode(',',  $order->without_id) as $without){
                $without = Without::where('id', $without)->first();
                $withouts[] = $without->name;
            }
            return $this->returnData(201, 'Make Order Successfully', compact('order', 'withouts'));
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(400, "Make Order Failed");
        }
        
    }



}
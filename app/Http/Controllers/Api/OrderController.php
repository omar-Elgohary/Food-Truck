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
use PhpParser\Node\Stmt\Foreach_;

class OrderController extends Controller
{
    use ApiResponseTrait;

    public function getPendingOrders()
    {
        try{
            if(auth()->user()->type == 'customer'){
                $orders = Order::where('customer_id', auth()->user()->id)->where('status', 'pending')->get();
                foreach($orders as $order){
                    $order['seller'] = User::where('id', $orders->first()->seller_id)->get();
                }
                return $this->returnData(201, 'Pending Orders Returned Successfully', $orders);
            }else{
                return $this->returnError(404, "There Are No Orders as You Aren't a Customer");
            }
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(404, "There Are No Pending Orders");
        }
    }





    public function getProcessingOrders()
    {
        try{
            if(auth()->user()->type == 'customer'){
                $orders = Order::where('customer_id', auth()->user()->id)->where('status', 'processing')->get();
                foreach($orders as $order){
                    $order['seller'] = User::where('id', $orders->first()->seller_id)->get();
                }
                return $this->returnData(201, 'Processing Orders Returned Successfully', $orders);
            }else{
                return $this->returnError(404, "There Are No Orders as You Aren't a Customer");
            }
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(404, "There Are No Processing Orders");
        }
    }





    public function getPreviousOrders()
    {
        try{
            if(auth()->user()->type == 'customer'){
                $orders = Order::where('customer_id', auth()->user()->id)
                ->where('status', 'deliverd')->orWhere('status', 'picked up')->orWhere('status', 'cancel_by_customer')
                ->get();
                foreach($orders as $order){
                    $order['seller'] = User::where('id', $orders->first()->seller_id)->get();
                }
                return $this->returnData(201, 'Previous Orders Returned Successfully', $orders);
            }else{
                return $this->returnError(404, "There Are No Orders as You Aren't a Customer");
            }
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(404, "There Are No Previous Orders");
        }
    }





    public function cancelOrder(Request $request, $order_id)
    {
        try{
            $order = Order::find($order_id);
            if(!$order){
                return $this->returnError(404, "Order Not Found");
            }
            if($order->confirmed == 0){
                return $this->returnError(404, "U Can't Cancel Order as Order isn't Confirmed");
            }

            if(auth()->user()->type == 'customer'){
                $order->update(['status' => 'cancel_by_customer']);
                $order['seller'] = User::where('id', $order->first()->seller_id)->get();
                return $this->returnData(201, 'Previous Orders Returned Successfully', $order);
            }else{
                return $this->returnError(404, "There Are No Orders as You Aren't a Customer");
            }
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(404, "There Are No Previous Orders");
        } 
    }







    public function makeOrder(Request $request, $seller_id, $section_id)    // add to cart
    {
        try{
            $seller = User::find($seller_id);
            $section = Section::find($section_id);
            if(auth()->user()->type != 'customer'){
                return $this->returnError(401, "You Can't make order as you aren't a Customer");
            }

            if(!$seller || $seller->type != 'seller'){
                return $this->returnError(404, "Seller Not Found");
            }

            if(!$section){ 
                return $this->returnError(404, "Section Not Found");
            }
            $without = implode(',', $request->without_id);

            if($request->product_id == null){
                return $this->returnError(404, "Product Not Found");
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

            if($request->without){
                foreach(explode(',',  $order->without_id) as $without){
                    $without = Without::where('id', $without)->first();
                    $withouts[] = $without->name;
                }
            }else{
                $withouts[] = null;
            }
            return $this->returnData(201, 'Make Order Successfully', compact('order', 'withouts'));
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(404, "Make Order Failed");
        }
        
    }



    public function confirmOrder(Request $request, $seller_id)
    {
        try{
            $seller = User::find($seller_id);
            if(auth()->user()->type != 'customer'){
                return $this->returnError(401, "You Can't confirm order as you aren't a Customer");
            }

            if(!$seller || $seller->type != 'seller'){
                return $this->returnError(404, "Seller Not Found");
            }

            $orders = Order::where('customer_id', auth()->user()->id)->where('seller_id', $seller_id)->get();
            foreach($orders as $order){
                if(!$seller->deliveryPrice){
                    return $this->returnData(201, 'Confirm Order Successfully', compact('orders'));
                }else{
                    $order->update([
                        'confirmed' => '1',
                        'deliveryPrice' => $seller->deliveryPrice,
                        'total' => ($order->productPrice) + ($seller->deliveryPrice),
                    ]);
                }
            }
            return $this->returnData(201, 'Confirm Order Successfully', compact('orders'));
        }catch(\Exception $e){
            echo $e;
            return $this->returnError(404, "Confirm Order Failed");
        }
    }
    

}
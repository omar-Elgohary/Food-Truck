<?php
namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiResponseTrait;

class SellerController extends Controller
{
    use ApiResponseTrait;

    public function newOrders(Request $request)
    {
        try{
            if(auth()->user()->type != 'seller'){
                return $this->returnError(404, "U Aren't a Seller");
            }

            if(auth()->user()->isVerified == 0){
                return $this->returnError(404, "U Are not Verified");
            }

            $orders = Order::where('seller_id', auth()->user()->id)->where('status', 'pending')->get();
            foreach($orders as $order){
                $order['customer'] = User::where('id', $order->customer_id)->get();
            }
            $Ordertotal = Order::where('seller_id', auth()->user()->id)
            ->where('customer_id', $order->customer_id)->sum('productPrice');
            $sellerDelivery = User::where('id', auth()->user()->id)->first()->deliveryPrice;
            $order['Ordertotal'] = $Ordertotal + $sellerDelivery;
                return $this->returnData(201, 'Orders Returned Successfully', $orders);
        }catch(\Exception $e){
            echo $e->getMessage();
            return $this->returnError(404, "Orders Not Found");
        }
    }





    public function currnetOrders()
    {
        try{
            if(auth()->user()->type != 'seller'){
                return $this->returnError(404, "U Aren't a Seller");
            }

            if(auth()->user()->isVerified == 0){
                return $this->returnError(404, "U Are not Verified");
            }

            $orders = Order::where('seller_id', auth()->user()->id)->where('status', 'processing')->get();
            foreach($orders as $order){
                $order['customer'] = User::where('id', $order->customer_id)->get();
            }
                return $this->returnData(201, 'Orders Returned Successfully', $orders);
        }catch(\Exception $e){
            echo $e->getMessage();
            return $this->returnError(404, "Orders Not Found");
        }
    }





    public function previousOrders(Request $request)
    {
        try{
            if(auth()->user()->type != 'seller'){
                return $this->returnError(404, "U Aren't a Seller");
            }

            if(auth()->user()->isVerified == 0){
                return $this->returnError(404, "U Are not Verified");
            }

            $orders = Order::where('seller_id', auth()->user()->id)->where('status', 'rejected_by_seller')
            ->orWhere('status', 'deliverd')->orWhere('status', 'picked up')->get();
            foreach($orders as $order){
                $order['customer'] = User::where('id', $order->customer_id)->get();
            }
                return $this->returnData(201, 'Orders Returned Successfully', $orders);
        }catch(\Exception $e){
            echo $e->getMessage();
            return $this->returnError(404, "Orders Not Found");
        }
    }





    public function acceptPendingOrders(Request $request, $customer_id)
    {
        try{
            if(auth()->user()->type != 'seller'){
                return $this->returnError(404, "U Aren't a Seller");
            }

            if(auth()->user()->isVerified == 0){
                return $this->returnError(404, "U Are not Verified");
            }

            $customer = User::find($customer_id);
            if(!$customer){
                return $this->returnError(404, "Customer Not Found");
            }

            $orders = Order::where('seller_id', auth()->user()->id)->where('customer_id', $customer_id)
            ->where('status', 'pending')->get();

            foreach($orders as $order){
                if($order->confirmed == 1){
                    $order->update([
                        'status' => 'accepted_by_seller',
                    ]);
                }else{
                    return $this->returnError(404, "Order Not Confirmed");
                }
            }
            $order['customer'] = User::where('id', $customer_id)->get();
            return $this->returnData(201, 'Order Accepted Successfully', $order);
        }catch(\Exception $e){
            echo $e->getMessage();
            return $this->returnError(404, "Orders Not Found");
        }
    }







    public function rejectPendingOrders(Request $request, $customer_id)
    {
        try{
            if(auth()->user()->type != 'seller'){
                return $this->returnError(404, "U Aren't a Seller");
            }

            if(auth()->user()->isVerified == 0){
                return $this->returnError(404, "U Are not Verified");
            }

            $customer = User::find($customer_id);
            if(!$customer){
                return $this->returnError(404, "Customer Not Found");
            }

            $orders = Order::where('seller_id', auth()->user()->id)->where('customer_id', $customer_id)
            ->where('status', 'pending')->get();

            foreach($orders as $order){
                if($order->confirmed == 1){
                    $order->update([
                        'status' => 'rejected_by_seller',
                    ]);
                }else{
                    return $this->returnError(404, "Order Not Confirmed");
                }
            }
            $order['customer'] = User::where('id', $customer_id)->get();
            return $this->returnData(201, 'Order Rejected Successfully', $order);
        }catch(\Exception $e){
            echo $e->getMessage();
            return $this->returnError(404, "Orders Not Found");
        }
    }

}

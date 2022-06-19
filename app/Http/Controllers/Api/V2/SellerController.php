<?php
namespace App\Http\Controllers\Api\V2;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Resources\V2\PurchaseHistoryMiniCollection;
use App\Http\Resources\V2\PurchaseHistoryCollection;
use App\Http\Resources\V2\PurchaseHistoryItemsCollection;
use App\Models\OrderDetail;

class SellerController extends Controller {


    function getOrderList(Request $request)
        {
            $order_query = Order::query();
            if ($request->payment_status != "" || $request->payment_status != null) {
                $order_query->where('payment_status', $request->payment_status);
            }
            if ($request->delivery_status != "" || $request->delivery_status != null) {
                $delivery_status = $request->delivery_status;
                $order_query->whereIn("id", function ($query) use ($delivery_status) {
                    $query->select('order_id')
                        ->from('order_details')
                        ->where('delivery_status', $delivery_status);
                });
            }
            
            return new PurchaseHistoryMiniCollection($order_query->where('seller_id', auth()->user()->id)->latest()->paginate(5));
        }


function getOrderDetails($id){
    $order_detail = Order::where('id', $id)->where('seller_id', auth()->user()->id)->get();
    // $order_query = auth()->user()->orders->where('id', $id);
    
    // return new PurchaseHistoryCollection($order_query->get());
    return new PurchaseHistoryCollection($order_detail);
}

function getOrderItems($id)
{
    $order_id = Order::select('id')->where('id', $id)->where('seller_id', auth()->user()->id)->first();
    $order_query = OrderDetail::where('order_id', $order_id->id);
    return new PurchaseHistoryItemsCollection($order_query->get());
}

}
?>
<?php

namespace App\Http\Controllers\Api\V2;
use App\Models\Shop;
use App\Models\ShopSchedule;

class DiscountShopController extends Controller
{

    public function index()
    {

        $shops = Shop::where('is_discounted','=',1)->with('logo','banner')->get();

        return response()->json($shops);
    }
    
    
    public function bigzlootShop($id)
    {
    // $schedule = ShopSchedule::where('shop_id',$request->shop_id)->first();

 $shop  = Shop::with('schedule','logo','banner')->where('id', $id)->first();
   // $schedule = ShopSchedule::where('shop_id',$shop->id)->first();

// $shop = Shop::join('shop_schedule', 'shops.id', '=', 'shop_schedule.shop_id')
//               ->get(['shops.*', 'shop_schedule.schedules']);

        if($shop!=null){
            if ($shop->verification_status != 0){
          return response()->json($shop);
            }
        }
    }
}

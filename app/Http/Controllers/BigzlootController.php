<?php

namespace App\Http\Controllers;

use App\Models\Bigzloot;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\User;
use App\Models\BusinessSetting;
use App\Models\BzSlider;
use App\Models\ShopSchedule;
use Auth;
use Hash;
use App\Notifications\EmailVerificationNotification;

class BigzlootController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bzsliders = BzSlider::all();
        $shops = Shop::where('is_discounted','=',1)->get();
        return view('frontend.bigzloot.index', compact('shops','bzsliders'));
    }
 function action(Request $request)
    {
     if($request->ajax())
     {
      $output = '';
      $query = $request->get('query');
      if($query != '')
      {
       $data = Shop::where('city', 'like', '%'.$query.'%')->get();
      }
      else
      {
       $data = Shop::where('is_discounted','=',1)->get();
      }
      $total_row = $data->count();
      $asst = "assets/img/placeholder-rect.jpg";
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        if ($row->sliders != null)
        {
          foreach (explode(',',$row->sliders) as $key => $slide)
          {
              $sld ='<img class="d-block lazyload img-fit h-150px" src="'. static_asset($asst).'" data-src="'.uploaded_asset($slide).'" alt="'.$key.' offer">';
           }
        }
        else
        {
        $sld = '<img class="d-block lazyload img-fit h-150px" src="'.static_asset($asst).'" ">';
        }
    
        if ($row->logo !== null)
        {
            $lgo = uploaded_asset($row->logo);
        }
        else
        {
            $lgo = static_asset($asst);
        }



        $output .= '<div class="col-md-6 p-5">
            <div class="shop-banner">
                <a href="'.route('bzshop.visit',$row->slug).'" class="text-reset d-block">
                 '.$sld.'
                </a>
            </div>
            <div class="shop-logo">
                <a href="'.route('bzshop.visit',$row->slug).'" class="text-reset">
                    <img src="'.$lgo.'" alt="'.$row->name.'" class="border lazyload rounded-circle shadow-2xl border-2 size-90px">
                </a>
            </div>
            <div class="shop-summary">
                <h4 class="shop-name">'.$row->name.'</h4>
                <p>'.$row->address.'</p>
            </div>
             </div>
        ';
       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }
    public function bz_filter_shop($slug, $type)
    {
        $shop  = Shop::where('slug', $slug)->first();
        if($shop!=null && $type != null){
            return view('frontend.bigzloot.index', compact('shop', 'type'));
        }
        abort(404);
    }

    public function bigzlootShopCreate()
    {
        if (Auth::check()) {
			if((Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'customer')) {
				flash(translate('Admin or Customer can not be a seller'))->error();
				return back();
			} if(Auth::user()->user_type == 'seller'){
				flash(translate('This user already a seller'))->error();
				return back();
			}
            
        } else {
            return view('frontend.bigzloot.discounted_seller_form');
        }
    }

    public function bigzlootShopStore(Request $request)
    {

        $user = null;
        if (!Auth::check()) {
            if (User::where('email', $request->email)->first() != null) {
                flash(translate('Email already exists!'))->error();
                return back();
            }
            if ($request->password == $request->password_confirmation) {
                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->user_type = "seller";
                $user->password = Hash::make($request->password);
                $user->save();
            } else {
                flash(translate('Sorry! Password did not match.'))->error();
                return back();
            }
        } else {
            $user = Auth::user();
            if ($user->customer != null) {
                $user->customer->delete();
            }
            $user->user_type = "seller";
            $user->save();
        }


        if (Shop::where('user_id', $user->id)->first() == null) {
            $shop = new Shop;
            $shop->user_id = $user->id;
            $shop->name = $request->name;
            $shop->address = $request->address;
            $shop->flat_discount = $request->flat_discount;
            $shop->is_discounted = 1;
            
            $shop->slug = preg_replace('/\s+/', '-', $request->name);
            if ($shop->save()) {
                auth()->login($user, false);
                if (BusinessSetting::where('type', 'email_verification')->first()->value != 1) {
                    $user->email_verified_at = date('Y-m-d H:m:s');
                    $user->save();
                } else {
                    $user->notify(new EmailVerificationNotification());
                }

                flash(translate('Your Shop has been created successfully!'))->success();
                return redirect()->route('shops.index');
            } else {
                $user->user_type == 'customer';
                $user->save();
            }
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }


    public function bigzlootShop($slug)
    {
    // $schedule = ShopSchedule::where('shop_id',$request->shop_id)->first();

        $shop  = Shop::where('slug', $slug)->first();
        $schedule = ShopSchedule::where('shop_id',$shop->id)->first();

        if($shop!=null){
            if ($shop->verification_status != 0){
                return view('frontend.bigzloot.single', compact('shop','schedule'));
            }
            else{
                return view('frontend.seller_shop_without_verification', compact('shop'));
            }
        }
        abort(404);
        return view('frontend.bigzloot.single');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bigzloot  $bigzloot
     * @return \Illuminate\Http\Response
     */
    public function show(Bigzloot $bigzloot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bigzloot  $bigzloot
     * @return \Illuminate\Http\Response
     */
    public function edit(Bigzloot $bigzloot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bigzloot  $bigzloot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bigzloot $bigzloot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bigzloot  $bigzloot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bigzloot $bigzloot)
    {
        //
    }
}

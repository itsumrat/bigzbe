@extends('frontend.layouts.app')

@section('customStyles')
<link rel="stylesheet" href="{{ static_asset('assets/css/custom-modified.css') }}">
@endsection 

@section('content')
<section class="bg-white">
<div class="container">
  <div class="row">
    <div class="col-md-12">
    @if ($shop->sliders != null)
                        @foreach (explode(',',$shop->sliders) as $key => $slide)
                                <img class="lazyload" width="100%" height="500px" src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($slide) }}" alt="{{ $key }} offer">
                        @endforeach
    @else
    <img class="lazyload" width="100%" height="500px" src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"">

                    @endif
        </div>
    </div>
    <div class="container p-5">
    <div class="row">
    <div class="col-md-8">
      <h2>{{$shop->name}} <span>{{$shop->shop_category}}</span></h2>
            <p><i class="las la la-map-marker la-2x"></i> {{$shop->address}}</p>
      <p>Offer</p>
      Flat {{$shop->flat_discount}}% Off
    </div>
    <div class="col-md-4">
    <div class="boxed-widget">
          <h3><i class="las la la-thumbtack la-1x "></i> Contact</h3>
          
          <ul class="listing-details-sidebar">
          <li> <i class="las la la-phone"></i> {{$shop->phone}}</li>
          </ul>
         
    </div>
   <div class="boxed-widget opening-hours">
        <h3><i class="las la la-clock-o la-1x "></i> Openning Hours</h3>
      <ul>
      @if($schedule)
    @foreach($schedule->schedules as $k=>$v)
    <li>
    <span>
       {{$k}}:
       @if($v['open']!=null){{$v['open']." AM -".$v['close']." PM"}}
       @else 
      Offday
       @endif
       </span>
       </li>
       <br>
    @endforeach
    @endif
    </ul>
    </div>
    </div>
  </div>
</div>
</section>
@if (!isset($type))
        <!--<section class="mb-5">-->
        <!--    <div class="container">-->
        <!--        <div class="aiz-carousel dots-inside-bottom mobile-img-auto-height" data-arrows="true" data-dots="true" data-autoplay="true">-->
        <!--            @if ($shop->sliders != null)-->
        <!--                @foreach (explode(',',$shop->sliders) as $key => $slide)-->
        <!--                    <div class="carousel-box">-->
        <!--                        <img class="d-block w-100 lazyload rounded h-200px h-lg-380px img-fit" src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($slide) }}" alt="{{ $key }} offer">-->
        <!--                    </div>-->
        <!--                @endforeach-->
        <!--            @endif-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</section>-->
        <section class="mb-4">
            <div class="container">
                <!--<div class="text-center mb-4">-->
                <!--    <h3 class="h3 fw-600 border-bottom">-->
                <!--        <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Featured Products')}}</span>-->
                <!--    </h3>-->
                <!--</div>-->
                <div class="row">
                    <div class="col">
                        <div class="aiz-carousel gutters-10" data-items="6" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-autoplay='true' data-infinute="true" data-dots="true">
                            @foreach ($shop->user->products->where('published', 1)->where('approved', 1)->where('seller_featured', 1) as $key => $product)
                                <div class="carousel-box">
                                    @include('frontend.partials.product_box_1',['product' => $product])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <section class="mb-4">
        <div class="container">
            <!--<div class="mb-4">-->
            <!--    <h3 class="h3 fw-600 border-bottom">-->
            <!--        <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">-->
            <!--            @if (!isset($type))-->
            <!--                {{ translate('New Arrival Products')}}-->
            <!--            @elseif ($type == 'top-selling')-->
            <!--                {{ translate('Top Selling')}}-->
            <!--            @elseif ($type == 'all-products')-->
            <!--                {{ translate('All Products')}}-->
            <!--            @endif-->
            <!--        </span>-->
            <!--    </h3>-->
            <!--</div>-->
            <div class="row gutters-5 row-cols-xxl-5 row-cols-lg-4 row-cols-md-3 row-cols-2">
                @php
                    if (!isset($type)){
                        $products = \App\Models\Product::where('user_id', $shop->user->id)->where('published', 1)->where('approved', 1)->orderBy('created_at', 'desc')->paginate(24);
                    }
                    elseif ($type == 'top-selling'){
                        $products = \App\Models\Product::where('user_id', $shop->user->id)->where('published', 1)->where('approved', 1)->orderBy('num_of_sale', 'desc')->paginate(24);
                    }
                    elseif ($type == 'all-products'){
                        $products = \App\Models\Product::where('user_id', $shop->user->id)->where('published', 1)->where('approved', 1)->paginate(24);
                    }
                @endphp
                @foreach ($products as $key => $product)
                    <div class="col mb-3">
                        @include('frontend.bigzloot.product_box_11',['product' => $product])
                    </div>
                @endforeach
            </div>
            <div class="aiz-pagination aiz-pagination-center mb-4">
                {{ $products->links() }}
            </div>
        </div>
    </section>

@endsection 
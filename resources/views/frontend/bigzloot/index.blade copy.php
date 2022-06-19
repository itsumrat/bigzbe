@extends('frontend.layouts.app')

@section('customStyles')
<link rel="stylesheet" href="{{ static_asset('assets/css/custom-modified.css') }}">
@endsection 

@section('content')
<div class="container">
  <div class="row">
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      @php $i =1; @endphp

      @foreach($bzsliders as $slideritem)
      <div class="carousel-item {{$i=='1' ? 'active':''}}">
        @php $i++; @endphp

        <img src="{{asset('uploads/bzslider/'.$slideritem->image)}}" class="d-block w-100" alt="...">
      </div>
      @endforeach
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  </div>
</div>
<div class="container">
  <div class="row">
                    <div class="flex-grow-1 front-header-search d-flex align-items-center bg-white">
                    <div class="position-relative flex-grow-1">
                        <input type="text" class="form-control" name="search" id="search"  placeholder="{{  translate('Search Shop') }}">
                        </div>
                    </div>
                </div>

                <div class="d-none d-lg-none ml-3 mr-0">
                    <div class="nav-search-box">
                        <a href="#" class="nav-box-link">
                            <i class="la la-search la-flip-horizontal d-inline-block nav-box-icon"></i>
                        </a>
                    </div>
                </div>

  </div>
</div>
<div class="container mt-2">
  <div class="row">

   @foreach($shops as $shop)
    <div class="col-md-6">
      <div class="shop-banner">
        <a href="{{ route('bzshop.visit', $shop->slug) }}" class="text-reset d-block">
        @if ($shop->sliders != null)
          @foreach (explode(',',$shop->sliders) as $key => $slide)
                  <img class="d-block lazyload img-fit h-150px" src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($slide) }}" alt="{{ $key }} offer">
          @endforeach
        @else
        <img class="d-block lazyload img-fit h-150px" src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" ">
        @endif
        </a>
      </div>
      <div class="shop-logo">
        <a href="{{ route('bzshop.visit', $shop->slug)}}" class="text-reset">
        <img src="@if ($shop->logo !== null) {{ uploaded_asset($shop->logo) }} @else {{ static_asset('assets/img/placeholder.jpg') }} @endif" alt="{{ $shop->name }}" class="border lazyload rounded-circle shadow-2xl border-2 size-90px"></a>
      </div>
      <div class="shop-summary">
          <h4 class="shop-name">{{$shop->name}}</h4>
          <p>{{$shop->address}}</p>
      </div>
    </div>
  @endforeach
  </div>
</div>
@endsection
@section('script')
<script>
$(document).ready(function(){

 fetch_customer_data();

 function fetch_customer_data(query = '')
 {
  $.ajax({
   url:"{{ route('bigzloot.action') }}",
   method:'GET',
   data:{query:query},
   dataType:'json',
   success:function(data)
   {
    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
   }
  })
 }

 $(document).on('keyup', '#search', function(){
  var query = $(this).val();
  fetch_customer_data(query);
 });
});
</script>
@endsection
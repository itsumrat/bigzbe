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
  <div class="row bzshp">
<p id="total_records"></p>
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
    console.log(data);
    $('.bzshp').html(data.table_data);
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
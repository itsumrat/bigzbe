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

                    @foreach ($bzsliders as $slideritem)
                        <div class="carousel-item {{ $i == '1' ? 'active' : '' }}">
                            @php $i++; @endphp

                            <img src="{{ asset('public/uploads/bzslider/' . $slideritem->image) }}" class="d-block w-100"
                                alt="...">
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
    </div>
    </div>
            <div class="container ">
            <div class="row">
                <div class="flex-grow-1  d-flex align-items-center bzsearch-container m-2">
                    <div class="position-relative flex-grow-1 bzsearch-container-item">
                        <input type="text" class="form-control" name="search" id="search"
                            placeholder="{{ translate('Search Shop by City') }}">

                    </div>
                    <div class="position-relative flex-grow-1 bzsearch-container-item m-2">
                        <input type="text" name="prod_shop_search" id="prod_shop_search" class="form-control"
                            placeholder="Search by shop name" />
                        <div id="countryList">
                        </div>
                    </div> 
                    <div class="position-relative flex-grow-1 bzsearch-container-item m-2">
                        <button class="btn dropdown-toggle" type="button" id="categoryMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Category
                        </button>
                        <div class="dropdown-menu" id="shopcategory" aria-labelledby="categoryMenuButton">
                            <span class="dropdown-item" name="shopcategory" value="all">All</span>
                            @foreach ($shopcat as $shop)
                                <span class="dropdown-item" name="shopcategory"
                                    value="{{ $shop->shop_category }}">{{ $shop->shop_category }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{ csrf_field() }}
        </div>

    <div class="container mt-2">
        <div class="row bzshp">
            <p id="total_records"></p>
        </div>
    </div>
@endsection


@section('script')
    <script>
        $(document).ready(function() {

            fetch_customer_data();

            function fetch_customer_data(query = '') {
                $.ajax({
                    url: "{{ route('bigzloot.action') }}",
                    method: 'GET',
                    data: {
                        query: query
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('.bzshp').html(data.table_data);
                        $('#total_records').text(data.total_data);
                    }
                })
            }

            $(document).on('keyup', '#search', function() {
                var query = $(this).val();
                fetch_customer_data(query);
            });

            $('#prod_shop_search').keyup(function() {
                var query = $(this).val();
                if (query != '') {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('bigzloot.shopfetch') }}",
                        method: "POST",
                        data: {
                            query: query,
                            _token: _token
                        },
                        success: function(data) {
                            $('#countryList').fadeIn();
                            $('#countryList').html(data);
                        }
                    });
                }
            });
            $(document).on('click', 'li', function() {
                $('#prod_shop_search').val($(this).text());
                $('#countryList').fadeOut();
            });
            $('#shopcategory > span').on('click', function() {

                //alert('TET');
                //alert($(this).text());
                //console.log();
                var query = $(this).text();
                //alert(query);
                fetch_customer_data(query);
            });
        });
    </script>
@endsection

@extends('frontend.layouts.app')


@section('content')



    <section class="mb-4">
        <div class="container">
            <div class="row gutters-5 row-cols-xxl-5 row-cols-lg-4 row-cols-md-3 row-cols-2">
                @foreach ($shipping_free as $key => $product)
                    <div class="col mb-3">
                        @include('frontend.partials.product_box_1',['product' => $product])
                    </div>
                @endforeach
            </div>

        </div>
    </section>


@endsection

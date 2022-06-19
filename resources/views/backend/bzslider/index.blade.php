@extends('backend.layouts.app')

@section('content')

		<div class="card">
			<div class="card-header">
				<h6 class="mb-0">{{ translate('Bigzloot Slider') }}</h6>
                <h4>
                    <a href="{{route('bzslider.create')}}" class="btn btn-primary float-right">Add Slider</a>
                </h4>
			</div>
			<div class="card-body">
                <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Link</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>

                @foreach ($bzslider as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->image}}
                        <img src="{{asset('uploads/bzslider/'.$item->image )}}" width="100px">
                    </td>
                    <td>{{$item->link}}</td>
                    <td><a href="">Edit</a></td>
                </tr>
                @endforeach
</tbody>
                </table>


			</div>
		</div>
@endsection
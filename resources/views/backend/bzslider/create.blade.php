@extends('backend.layouts.app')

@section('content')

		<div class="card">
			<div class="card-header">
				<h6 class="mb-0">{{ translate('Slider') }}</h6>
                <h4>
                    <a href="{{route('bzslider')}}" class="btn btn-primary float-right">Back</a>
                </h4>
			</div>
			<div class="card-body">
				<form action="{{route('bzslider.store')}}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label>{{ translate('Link') }}</label>
                        <input type="text" name="link" class="form-control">
					</div>
					<div class="form-group">
						<label>{{ translate('Image') }}</label>
                        <input type="file" name="image" class="form-control">
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
@endsection
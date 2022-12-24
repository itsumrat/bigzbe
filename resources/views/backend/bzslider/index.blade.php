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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                @foreach ($bzslider as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->image}}
                        <img src="{{asset('/public/uploads/bzslider/'.$item->image )}}" width="100px">
                    </td>
                    <td>{{$item->link}}</td>
                    <td><a href="{{route('bzslider.edit',['id'=>$item->id])}}"><i class="las la-edit"></i></a>
                    
                    <a href="javascript:void(0)" class="confirm-alert" data-href="{{ route('bzslider.destroy', $item->id ) }}" data-target="#delete-modal">
                            <i class="las la-trash mr-2"></i>
                        </a></td>
                </tr>
                @endforeach
</tbody>
                </table>


			</div>
		</div>
@endsection

@section('modal')
<div id="delete-modal" class="modal fade">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h6">{{ translate('Delete Confirmation') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body text-center">
                <p class="mt-1">{{ translate('Are you sure to delete this file?') }}</p>
                <button type="button" class="btn btn-link mt-2" data-dismiss="modal">{{ translate('Cancel') }}</button>
                <a href="" class="btn btn-primary mt-2 comfirm-link">{{ translate('Delete') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
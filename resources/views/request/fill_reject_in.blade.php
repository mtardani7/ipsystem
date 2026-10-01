@extends('layouts.app')

@section('content')
<div class="container">

	<div>
		<label style="font-size:24px;">Reject Reason</label>
	</div>

	<div class="well well-sm">

		<form class="form-horizontal" method='post' action='{{ action('ReqIncomingController@fill_reject', $req_id) }}'>
			{{csrf_field()}}

			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Reject By</label>
				<div class="col-sm-4">
					<input type="input" value="{{ Auth::user()->name }}" id="by" name="by" readonly>
				</div>
			</div>

			<div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">Reason</label>
				<div class="col-sm-8">
					<textarea class="form-control" rows="6" name="rmk" id="rmk"></textarea>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="hidden" name="request_id" id='request_id' value="{{$reqs->id}}">
					<button type="submit" class="btn btn-sm btn-primary">Save</button>
					<a href='javascript:history.back()' class='btn btn-sm btn-primary'>Cancel</a>
				</div>
			</div>

		</form>
	</div>
</div>
@endsection
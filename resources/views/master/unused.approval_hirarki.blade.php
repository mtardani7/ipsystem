@extends('layouts.app')

@section('content')
<div class="container">
  <div>
    <label style="font-size:24px;">Approval Hirarki</label>
  </div>
  <a href='{{action('ApprovalHirarkiController@mrindex')}}' class='btn btn-xs btn-default'>Manage MR Approval</a>
  <div class="well well-sm">
    @if (Session::has('data'))
    <div class="alert alert-danger">
      {{ Session::get('data')}}
    </div>
    @endif

    @if ($message = Session::get('success'))
    <div class="custom-alerts alert alert-success fade in">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
      {!! $message !!}
    </div>
    <?php Session::forget('success'); ?>
    @endif
    <form class="form-horizontal" method='post' action='input_approval_hirarki'>
      {{csrf_field()}}
      <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Dept</label>
        <div class="col-sm-4">
          <select id='dept' name='dept' class='form-control' required>
            <option value=''>- select -&nbsp;</option>
            @foreach ($divs as $div)
            <option value='{{$div->DIVID}}'>{{$div->DIVID}}&nbsp;</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Plant</label>
        <div class="col-sm-4">
          <select id='plant' name='plant' class='form-control' required>
            <option value=''>- select -&nbsp;</option>
            @foreach ($plants as $plant)
            <option value='{{$plant->PLANTID}}'>{{$plant->PLANTID}}&nbsp;</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Approval 1</label>
        <div class="col-sm-4">
          <select id='approval1' name='approval1' class='form-control'>
            <option value=''>- select -&nbsp;</option>
            @foreach ($users as $user)
            <option value='{{$user->name}}'>{{$user->name}}&nbsp;</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Approval 2</label>
        <div class="col-sm-4">
          <select id='approval2' name='approval2' class='form-control'>
            <option value=''>- select -&nbsp;</option>
            @foreach ($users as $user)
            <option value='{{$user->name}}'>{{$user->name}}&nbsp;</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Approval Final</label>
        <div class="col-sm-4">
          <select id='approval_final' name='approval_final' class='form-control' required>
            <option value=''>- select -&nbsp;</option>
            @foreach ($users as $user)
            <option value='{{$user->name}}'>{{$user->name}}&nbsp;</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-sm btn-primary">Save</button>
        </div>
        <div class="col-sm-offset-2 col-sm-10">
          <p style="font-size:10px;padding-top:10px;">* approval final must filled</p>
        </div>
      </div>

    </form>
  </div>
  <table class="table table-bordered" id='mt' width='100%' height="" data-toggle="dataTable" data-form="deleteForm">
    <thead>
      <tr>
        <th style="color:white;" bgcolor="#666666" width='40'>ID.</th>
        <th style="color:white;" bgcolor="#666666" width='150'>Dept</th>
        <th style="color:white;" bgcolor="#666666" width='150'>Plant</th>
        <th style="color:white;" bgcolor="#666666" width='150'>Approval 1</th>
        <th style="color:white;" bgcolor="#666666" width='150'>Approval 2</th>
        <th style="color:white;" bgcolor="#666666" width=''>Approval Final</th>
        <th style="color:white;" bgcolor="#666666" width='100'>Action</th>
      </tr>
    </thead>
    <tbody>
      @php $no = ($datas->currentpage()-1)* $datas->perpage() + 1; @endphp
      @foreach($datas as $data)
      <tr bgcolor="#fff">
        <td align='center'>{{$data->id}}</td>
        <td align='center'>{{$data->dept}}</td>
        <td align='center'>{{$data->plant}}</td>
        <td align='center'>{{$data->approval1}}</td>
        <td align='center'>{{$data->approval2}}</td>
        <td align='center'>{{$data->approval_final}}</td>
        <td align='center' width='10%'>
          <span style="float:left;"><a href='{{action('ApprovalHirarkiController@edit', $data->id)}} ' class='btn btn-success btn-xs'>edit</a>
          </span> |
          <span style="float:right;">
            <form class="form-delete" method='post' action='{{ action('ApprovalHirarkiController@destroy', $data->id) }}'>
              <input type="hidden" name="_method" value="delete" />
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <button type="submit" class="btn btn-danger btn-xs" name="delete_modal">Delete</button>
            </form>

          </span>
        </td>
      </tr>

      @php $no++; @endphp
      @endforeach

    </tbody>
  </table>
  {{ $datas->links() }}
</div>
<div class="modal" id="confirm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Delete Confirmation</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you, want to delete ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" id="delete-btn">Delete</button>
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

@endsection
@extends('layouts.app')


@section('content')

<div class="container">

  <div>
    <label style="font-size:24px;">Edit Note</label>
  </div>

  <div class="well well-sm">

    @if (Session::has('data'))
    <div class="alert alert-danger">
      {{ Session::get('data')}}
    </div>
    @endif

    <form class="form-horizontal" method='post' action='{{ action('NoteController@update', $id) }}'>
      {{csrf_field()}}
      <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Subject *</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id='subject' name='subject' value="{{$note->SUBJECT}}" required>
        </div>
      </div>
      <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-4">
          <textarea class="form-control" rows="3" name="desc" id="desc" required>{{$note->DESCRIPTION}}</textarea>
        </div>
      </div>
      <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">PIC *</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id='pic' name='pic' value="{{$note->PIC}}" required>
        </div>
      </div>

      <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Show *</label>
        <div class="col-sm-4">
          <select id='show' name='show' class='form-control'>
            <option value='{{$note->sharestatus}}'>@php if ($note->SHARESTATUS=='Y'){echo "Yes";}else{echo "No";} @endphp &nbsp;</option>
            <option value='Y'>Yes&nbsp;</option>
            <option value='N'>No&nbsp;</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <input type="hidden" class="form-control" id='user' name='user' value="{{ Auth::user()->name }}">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-sm btn-primary">Save</button>
          <a href='javascript:history.back()' class='btn btn-sm btn-primary'>Cancel</a>
        </div>
        <div class="col-sm-offset-2 col-sm-10">
          <p style="font-size:10px;padding-top:10px;">* must be filled</p>
        </div>
      </div>

    </form>
  </div>

</div>
@endsection
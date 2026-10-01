@extends('layouts.app')




@section('content')

  <div class="container">
    <h1 class="page-header">Integration Demo Page</h1>
   
    <div class="row">
     
      <div class="col-md-6">
        
        <h2>Standalone File Button</h2>
        <div class="input-group">
          <span class="input-group-btn">
            <a id="lfm2" data-input="thumbnail2" data-preview="holder2" class="btn btn-primary">
              <i class="fa fa-picture-o"></i> Choose
            </a>
          </span>
          <input id="thumbnail2" class="form-control" type="text" name="filepath">
        </div>
      
      </div>
    </div>
   
  </div>

 
 
  <script src="{{ asset('vendor/laravel-filemanager/js/lfm.js') }}"></script>
  <!--<script>
    {!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/lfm.js')) !!}
  </script>-->
  <script>
   var route_prefix = "{{ url(config('lfm.url_prefix', config('lfm.prefix'))) }}";
    $('#lfm').filemanager('image', {prefix: route_prefix});
    $('#lfm2').filemanager('file', {prefix: route_prefix});
  </script>



@endsection


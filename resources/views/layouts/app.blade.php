<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sticky-footer-navbar.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- <script src="{{ asset('js/jquery.min.js') }}"></script> -->
    <script src="{{ asset('vendor/laravel-filemanager/js/lfm.js') }}"></script>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>-->
    <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>-->
    <link href="{{ asset('css/bootstrap-datepicker.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img style="max-width:70px; margin-top: -12px;" src="{{ asset('img/logo3.png') }}">
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    @if (Auth::guest())
                    <ul class="nav navbar-nav">
                    </ul>
                    @else
                    <?php
                    $reviewDriver = DB::connection('mysql3')->getDriverName();
                    $nextReviewDate = App\DocumentReviewCycle::nextReviewDateExpression($reviewDriver);
                    $today = $reviewDriver === 'sqlite' ? "DATE('now')" : 'CURDATE()';
                    $reviewDueCount = App\Masterlist::whereIn('CATID', ['SOP', 'WI'])
                        ->where('DOCSTATUS', 'Active')
                        ->where('OWNER_ID', Auth::user()->id)
                        ->whereRaw('('.$nextReviewDate.') <= '.$today)
                        ->count();
                    ?>
                    @if (Auth::user()->custom=='superuser')
                    <ul class="nav navbar-nav">
                        <li class="@php if( preg_match( '/^home.*/', \Request::route()->getName())) echo " active"; @endphp"><a href="{{ route('home') }}">Home</a></li>
                        <li class="{{ (\Request::route()->getName() == 'notes') ? 'active' : '' }}"><a href="{{ route('notes') }}">Notes</a></li>
                        <li class="dropdown {{ (\Request::route()->getName() == 'input_plant' ) || (\Request::route()->getName() == 'input_div' ) || (\Request::route()->getName() == 'input_dist' ) || (\Request::route()->getName() == 'input_cat' ) || (\Request::route()->getName() == 'input_list' ) ? 'active' : '' }}">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Master <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('input_plant') }} ">Input Plant</a></li>
                                <li><a href="{{ route('input_div') }}">Input Division</a></li>
                                <li><a href="{{ route('input_dist') }}">Input Distribution</a></li>
                                <li><a href="{{ route('input_cat') }}">Input Category</a></li>
                                <li><a href="{{ route('load_doc') }}" ;>Load Document</a></li>
                                <li><a href="{{ route('input_list') }}">Input Masterlist</a></li>
                                <li><a href="{{ route('document_owner') }}">Document Owner &amp; Review @if($reviewDueCount > 0)<span class="badge">{{$reviewDueCount}}</span>@endif</a></li>
                            </ul>
                        </li>
                        <li class="dropdown {{ (\Request::route()->getName() == 'user') ? 'active' : '' }}">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administration <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('user') }} ">User</a></li>
                                <li><a href="{{ route('approval_hirarki') }} ">Approval Hirarki</a></li>
                                <li><a href="{{ route('data_vendor') }} ">Data Vendor</a>
                                <li><a href="{{ route('purc_form_report') }} ">Purchasing Form Report</a>
                                <li><a href="{{ route('mkt_form_report') }} ">Marketing Form Report</a>
                            </ul>
                        </li>
                        <li class="dropdown <?php $str = Request::route()->getName();
                                            if (strpos($str, 'req') !== false) {
                                                echo "active";
                                            } ?> ">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php  ?> Request <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('create_req') }} ">Create Request</a></li>
                                <li><a href="{{ route('approval_req') }}">Approval</a></li>
                                <li><a href="{{ route('history_req') }}">History</a></li>
                                <?php
                                $t_in = App\Req::where('form_saved', 'yes')->where('status', 'waiting')->where('verified', 'no')->count();
                                ?>
                                <li><a href="{{ route('incoming_req') }}">Incoming Request <span class="badge">{{$t_in}}</span></a></li>
                                <li><a href="{{ route('done_req') }}">Done Request</a></li>
                            </ul>
                        </li>
                        <!--<li class="dropdown {{ (\Request::route()->getName() == 'file' ) || (\Request::route()->getName() == 'file_create' )  ? 'active' : '' }}">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Test <span class="caret"></span></a>
								  <ul class="dropdown-menu" >
									<li><a href="{{ route('file') }} ">file</a></li>
                                    <li><a href="{{ route('file_create') }} ">Upload file</a></li>
                                    <li><a href="{{ route('sendmail') }} ">Send Email</a></li>
                                    <li><a href="{{ route('delete_file') }} ">Delete File</a></li>
                                    <li><a href="{{ route('form_it-01') }} ">Form IT 01</a></li>
                                    <li><a href="{{ route('ajax_crud') }} ">Ajax Crud</a></li>
								  </ul>
								</li>-->
                        <li class="{{ (\Request::route()->getName() == 'report') ? 'active' : '' }}"><a href="{{ route('report') }}">Report</a></li>
                        <li class="{{ (\Request::route()->getName() == 'form') ? 'active' : '' }}"><a href="{{ route('form') }}" ;>Form</a></li>
                        <li class="{{ (\Request::route()->getName() == 'changelog') ? 'active' : '' }}"><a href="{{ route('changelog') }}">ChangeLog</a></li>
                    </ul>
                    @elseif (Auth::user()->custom=='admin')
                    <ul class="nav navbar-nav">
                        <li class="@php if( preg_match( '/^home.*/', \Request::route()->getName())) echo " active"; @endphp"><a href="{{ route('home') }}">Home</a></li>
                        <li class="{{ (\Request::route()->getName() == 'notes') ? 'active' : '' }}"><a href="{{ route('notes') }}">Notes</a></li>
                        <li class="dropdown {{ (\Request::route()->getName() == 'input_plant' ) || (\Request::route()->getName() == 'input_div' ) || (\Request::route()->getName() == 'input_dist' ) || (\Request::route()->getName() == 'input_cat' ) || (\Request::route()->getName() == 'input_list' ) ? 'active' : '' }}">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Master <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('input_plant') }} ">Input Plant</a></li>
                                <li><a href="{{ route('input_div') }}">Input Division</a></li>
                                <li><a href="{{ route('input_dist') }}">Input Distribution</a></li>
                                <li><a href="{{ route('input_cat') }}">Input Category</a></li>
                                <li><a href="{{ route('load_doc') }}" ;>Load Document</a></li>
                                <li><a href="{{ route('input_list') }}">Input Masterlist</a></li>
                                <li><a href="{{ route('test_lfm') }}">Test LFM</a></li>
                            </ul>
                        </li>
                        <li class="{{ (\Request::route()->getName() == 'document_owner') ? 'active' : '' }}"><a href="{{ route('document_owner') }}">Document Review @if($reviewDueCount > 0)<span class="badge">{{$reviewDueCount}}</span>@endif</a></li>
                        <li class="dropdown <?php //if (strpos(\Request::route()->getName(), 'history_req_view') !== true) echo "active"; 
                                            ?> {{ (\Request::route()->getName() == 'create_req' ) || (\Request::route()->getName() == 'create_req_form' )  || (\Request::route()->getName() == 'approval_req' ) || (\Request::route()->getName() == 'history_req' )  ? 'active' : '' }}">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Request <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('create_req') }} ">Create Request</a></li>
                                <li><a href="{{ route('approval_req') }}">Approval</a></li>
                                <li><a href="{{ route('history_req') }}">History</a></li>
                                <?php
                                $t_in = App\Req::where('form_saved', 'yes')->where('status', 'waiting')->where('verified', 'no')->count();
                                ?>
                                <li><a href="{{ route('incoming_req') }}">Incoming Request <span class="badge">{{$t_in}}</span></a></li>
                                <li><a href="{{ route('done_req') }}">Done Request</a></li>
                            </ul>
                        </li>
                        <li class="{{ (\Request::route()->getName() == 'report') ? 'active' : '' }}"><a href="{{ route('report') }}">Report</a></li>
                        <li class="{{ (\Request::route()->getName() == 'form') ? 'active' : '' }}"><a href="{{ route('form') }}" ;>Form</a></li>
                        <li class="{{ (\Request::route()->getName() == 'changelog') ? 'active' : '' }}"><a href="{{ route('changelog') }}">ChangeLog</a></li>
                    </ul>
                    @else
                    <ul class="nav navbar-nav">
                        <li class="@php if( preg_match( '/^home.*/', \Request::route()->getName())) echo " active"; @endphp"><a href="{{ route('home') }}">Home</a></li>
                        <li class="dropdown {{ (\Request::route()->getName() == 'input_plant' ) || (\Request::route()->getName() == 'input_div' ) || (\Request::route()->getName() == 'input_cat' ) || (\Request::route()->getName() == 'input_list' ) ? 'active' : '' }}">
                        <li class="{{ (\Request::route()->getName() == 'document_owner') ? 'active' : '' }}"><a href="{{ route('document_owner') }}">Document Review @if($reviewDueCount > 0)<span class="badge">{{$reviewDueCount}}</span>@endif</a></li>
                        <li class="dropdown {{ (\Request::route()->getName() == 'create_req' ) || (\Request::route()->getName() == 'approval_req' ) || (\Request::route()->getName() == 'history_req' ) ? 'active' : '' }}">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Request <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('create_req') }} ">Create Request</a></li>
                                @if (Auth::user()->level!='staff') <li><a href="{{ route('approval_req') }}">Approval</a></li> @endif
                                <li><a href="{{ route('history_req') }}">History</a></li>
                            </ul>
                        </li>
                        <li class="dropdown {{ (\Request::route()->getName() == 'user') ? 'active' : '' }}">
                            @if (Auth::user()->dept =='PRC')
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administration <span class="caret"></span></a>

                            <ul class="dropdown-menu">
                                <li><a href="{{ route('data_vendor') }} ">Data Vendor</a></li>
                                <li><a href="{{ route('purc_form_report') }} ">Purchasing Form Report</a></li>
                            </ul>

                        </li>
                        @endif
                        <li class="{{ (\Request::route()->getName() == 'form') ? 'active' : '' }}"><a href="{{ route('form') }}" ;>Form</a></li>
                        <li class="{{ (\Request::route()->getName() == 'changelog') ? 'active' : '' }}"><a href="{{ route('changelog') }}" ;>ChangeLog</a></li>
                    </ul>
                    @endif
                    @endif
                    <ul class="nav navbar-nav navbar-right">
                        @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <!--<li><a href="{{ route('register') }}">Register</a></li>-->
                        @else
                        @if (Auth::user()->level!='staff')
                        <?php
                        $user = Auth::user()->name;
                        $ids = App\Req::where('approval1', $user)->whereNull('approval1_date')->where('form_saved', 'yes')->where('status', 'waiting')
                            ->orWhere('approval2', $user)->whereNotNull('approval1_date')->whereNull('approval2_Date')->where('form_saved', 'yes')->where('status', 'waiting')->where('verified', 'yes')
                            ->orWhere('approval_final', $user)->whereNotNull('approval1_date')->whereNotNull('approval2_Date')->whereNull('approval_final_date')->where('form_saved', 'yes')->where('status', 'waiting')->where('verified', 'yes')
                            ->orWhere('approval_final', $user)->whereNull('approval1')->whereNull('approval2')->whereNull('approval_final_date')->where('type', '<>', 'form_change-folder')->where('form_saved', 'yes')->where('status', 'waiting')->where('verified', 'yes')
                            ->orWhere('approval_mr', $user)->whereNotNull('approval1_date')->whereNotNull('approval2_Date')->whereNotNull('approval_final_date')->whereNull('approval_mr_date')->where('form_saved', 'yes')->where('status', 'waiting')->where('verified', 'yes')
                            ->orWhere('approval_mr', $user)->whereNull('approval1')->whereNull('approval2')->whereNotNull('approval_final_date')->whereNull('approval_mr_date')->where('type', '<>', 'form_change-folder')
                            ->where('form_saved', 'yes')->where('status', 'waiting')->where('verified', 'yes')->count();
                        $ids2 = App\Req::where('form_saved', 'yes')

                            ->count();
                        $t_ch = App\Req::where('form_saved', 'yes')->where('status', 'waiting')->where('type', 'form_change-folder')->where('approval_final', $user)->whereNull('approval_final_date')->count();
                        $t_notif = $ids + $t_ch + $reviewDueCount;
                        ?>
                        <li><a href="{{ route('approval_req') }}">Approval <span class="badge">{{$t_notif}}</span></a></li>
                        @endif
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                                <li><a href="{{ route('changepwd') }} ">Change Password</a></li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')
    </div>

    <script type="text/javascript">
        (function() {

            function domReady(callback) {
                if (document.readyState === "complete" || document.readyState === "interactive") {
                    setTimeout(callback, 0);
                } else if (document.addEventListener) {
                    document.addEventListener("DOMContentLoaded", callback);
                } else {
                    document.attachEvent("onreadystatechange", function() {
                        if (document.readyState === "complete") {
                            callback();
                        }
                    });
                }
            }

            domReady(function() {

                if (typeof jQuery === "undefined") {
                    console.error("jQuery is not loaded!");
                    return;
                }

                jQuery(function($) {
                    $('ul.tree').hide();

                    $(document).on('click', '.tree-toggle', function(e) {
                        e = e || window.event;
                        if (e.preventDefault) e.preventDefault();
                        else e.returnValue = false;

                        $(this)
                            .parent()
                            .children('ul.tree')
                            .first()
                            .toggle(200);
                    });

                });
            });

        })();
    </script>
    <!--<script src="{{asset('js/ajax-crud.js')}}"></script>-->
    <!-- <script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script> -->
    <script type="text/javascript" src="{{ asset('js/jquery.tablesorter.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('table[data-form="deleteForm"]').on('click', '.form-delete', function(e) {
                e.preventDefault();
                var $form = $(this);
                $('#confirm').modal({
                        backdrop: 'static',
                        keyboard: false
                    })
                    .on('click', '#delete-btn', function() {
                        $form.submit();
                    });
            });
        });
    </script>

    <script>
        jQuery(document).ready(function($) {
            jQuery('#btn-add').click(function() {
                jQuery('#btn-save').val("add");
                jQuery('#modalFormData').trigger("reset");
                jQuery('#linkEditorModal').modal('show');
            });

            jQuery('body').on('click', '.open-modal', function() {
                var link_id = $(this).val();
                $.get('links/' + link_id, function(data) {
                    jQuery('#link_id').val(data.id);
                    jQuery('#link').val(data.url);
                    jQuery('#description').val(data.description);
                    jQuery('#btn-save').val("update");
                    jQuery('#linkEditorModal').modal('show');
                })
            });

            $("#btn-save").click(function(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
                var formData = {
                    url: jQuery('#link').val(),
                    description: jQuery('#description').val(),
                };
                var state = jQuery('#btn-save').val();
                var type = "POST";
                var link_id = jQuery('#link_id').val();
                var ajaxurl = 'links';
                if (state == "update") {
                    type = "PUT";
                    ajaxurl = 'links/' + link_id;
                }
                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        var link = '<tr id="link' + data.id + '"><td>' + data.id + '</td><td>' + data.url + '</td><td>' + data.description + '</td>';
                        link += '<td><button class="btn btn-info open-modal" value="' + data.id + '">Edit</button>&nbsp;';
                        link += '<button class="btn btn-danger delete-link" value="' + data.id + '">Delete</button></td></tr>';
                        if (state == "add") {
                            jQuery('#links-list').append(link);
                        } else {
                            $("#link" + link_id).replaceWith(link);
                        }
                        jQuery('#modalFormData').trigger("reset");
                        jQuery('#linkEditorModal').modal('hide')
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            });

            jQuery('.delete-link').click(function() {
                var link_id = $(this).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "DELETE",
                    url: 'links/' + link_id,
                    success: function(data) {
                        console.log(data);
                        $("#link" + link_id).remove();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            });
        });
    </script>

    <script>
        $(function() {
            $("#myTable").tablesorter();
        });
    </script>

</body>

</html>

@if (Auth::check())
<footer class="footer" style="">
    <div class="container">
        <p class="text-muted">Copyright &copy <?php echo date("Y"); ?>, PT. Rapid Plast Indonesia.</p>
    </div>
</footer>
@endif
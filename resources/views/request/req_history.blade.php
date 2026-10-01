@extends('layouts.app')

@section('content')
<div class="container">
    @if (Session::has('data'))
        <div class="custom-alerts alert alert-success fade in">
            {{ Session::get('data') }}
        </div>
    @endif

    @if ($message = Session::get('success'))
        <div class="custom-alerts alert alert-success fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            {!! $message !!}
        </div>
        <?php Session::forget('success'); ?>
    @endif

    <div>
        <label style="font-size:24px;">Request History</label>
    </div>

    <div style="margin-bottom:10px;">
        <span style="float:left;">
            <!--<a href='# ' class='btn btn-default btn-xs'>New data</a>
            <a href='# ' class='btn btn-default btn-xs'>New data</a>
            <a href='# ' class='btn btn-default btn-xs'>New data</a>-->
        </span>
        &nbsp;
        <span style="float:right;margin-bottom:5px;">
            <table width='650'>
                <tr>
                    <form action='{{ route('history_search') }}' method='post'>
                        {{ csrf_field() }}
                        <td class='tableContent'>Select type :</td>
                        <td class='tableContent'>
                            <select id='type' name='type' class='form-control' style='width:97%;' required>
                                <option value='form_p4-no7'>form_p4-no7&nbsp;</option>
                                <option value='form_p4-no8'>form_p4-no8&nbsp;</option>
                            </select>
                        </td>
                        <td class='tableContent'>Select field :</td>
                        <td class='tableContent'>
                            <select id='field' name='field' class='form-control' style='width:97%;' required>
                                <option value='docid'>Doc. ID&nbsp;</option>
                                <option value='desc'>Doc. Desc&nbsp;</option>
                            </select>
                        </td>
                        <td class='tableContent'>
                            <input type='text' id='keyword' name='keyword' style='width:97%;'/>
                        </td>
                        <td colspan='2' class='tableField' align='right'>
                            <input class="btn btn-sm btn-primary" type='submit' id='go' name='submit' value='Search' style='width:97%;'/>
                        </td>
                    </form>
                </tr>
            </table>
        </span>
    </div>

    <table class="table table-bordered" id='mt' width='100%' height="" data-toggle="dataTable" data-form="deleteForm">
        <thead>
            <tr>
                <th style="color:white;" bgcolor="#666666" width='70'>Req ID</th>
                <th style="color:white;" bgcolor="#666666" width='200'>Date</th>
                <th style="color:white;" bgcolor="#666666" width='90'>Req By</th>
                <th style="color:white;" bgcolor="#666666" width='200'>Dept</th>
                <th style="color:white;" bgcolor="#666666" width='200'>Plant</th>
                <th style="color:white;" bgcolor="#666666" width='200'>Req Type</th>
                <th style="color:white;" bgcolor="#666666" width='300'>Status</th>
                <th style="color:white;" bgcolor="#666666" width='200'>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $no = ($reqs->currentpage()-1) * $reqs->perpage() + 1; @endphp
            @foreach($reqs as $req)
                <tr bgcolor="#fff">
                    <td align='center'>{{ $req['id'] }}</td>
                    <td align='center'>{{ $req['date_request'] }}</td>
                    <td align='center'>{{ $req['reqby'] }}</td>
                    <td align='center'>{{ $req['dept'] }}</td>
                    <td align='center'>{{ $req['plant'] }}</td>
                    <td align='center'>{{ $req['type'] }}</td>
                    <td align='center' 
                        @if($req['status'] == 'approved')
                            bgcolor='#8bf76b'
                        @elseif($req['status'] == 'waiting')
                            bgcolor='#f7c86b'
                        @elseif($req['status'] == 'uploaded')
                            bgcolor='#b3d9ff'
                        @else
                            bgcolor='#cccccc'
                        @endif>
                        <?php
                            if ($req['status'] == 'uploaded') {
                                echo "Uploaded to IPSystem<br>";
                            }
                            if ($req['verified'] == 'no') {
                                if ($req['type'] == 'form_it-01') {
                                    echo "Verification from IT ";
                                } else {
                                    echo "Verification from Doc. Controller ";
                                }
                            }
                            if ($req['approval1_date'] != null) {
                                echo "Approved by <b>".$req->approval1."</b> ".date('Y-m-d', strtotime($req->approval1_date))."<br>";
                            }
                            if ($req['approval2_date'] != null) {
                                echo "Approved by <b>".$req->approval2."</b> ".date('Y-m-d', strtotime($req->approval2_date))."<br>";
                            }
                            if ($req['approval_final_date'] != null) {
                                echo "Approved by <b>".$req->approval_final."</b> ".date('Y-m-d', strtotime($req->approval_final_date))."<br>";
                            }
                            if ($req['approval_mr_date'] != null) {
                                echo "Approved by MR <b>".$req->approval_mr."</b> ".date('Y-m-d', strtotime($req->approval_mr_date))."<br>";
                            }
                            if ($req['status'] == 'waiting') {
                                echo "Waiting<br>";
                            }
                            if ($req['status'] == 'waiting' && $req['approval1'] != null && $req['approval1_date'] == null) {
                                echo "Approval 1 <b>$req->approval1</b><br>";
                            }
                            if ($req['status'] == 'waiting' && $req['approval2'] != null && $req['approval2_date'] == null) {
                                echo "Approval 2 <b>$req->approval2</b><br>";
                            }
                            if ($req['status'] == 'waiting' && $req['approval_final'] !== null && $req['approval_final_date'] == null) {
                                echo "Approval Final <b>$req->approval_final</b><br>";
                            }
                            if ($req['status'] == 'waiting' && $req['approval_mr'] !== null && $req['approval_mr_date'] == null) {
                                echo "Approval MR <b>$req->approval_mr</b><br>";
                            }
                            if ($req['status'] == 'reject') {
                                echo "Rejected by<br><b>".$req['reject_by']."</b> on ".date('Y-m-d', strtotime($req['reject_date']))." reason <b>".$req['reject_rmk']."</b><br>";
                            }
                        ?>
                    </td>
                    <td align='center'>
                        <span style="float:left;">
                            <a href='{{ action('ReqHistoryController@view', $req['id']) }}' class='btn btn-success btn-xs'>view</a>
                            @if($req['status'] != 'uploaded' && $req['status'] != 'approved')
                                <a href='{{ action('ReqHistoryController@edit', $req['id']) }}' class='btn btn-primary btn-xs'>edit</a>
                            @endif
                        </span>
                        @if($req['status'] != 'uploaded')
                            <span style="float:right;">
                                {!! Form::open(['action' => ['ReqHistoryController@destroy', $req['id']], 'method' => 'POST', 'class' => 'form-delete']) !!}
                                    {!! Form::hidden('_method', 'DELETE') !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs delete', 'name' => 'delete_modal', 'onclick' => 'return confirmDelete(event)']) !!}
                                {!! Form::close() !!}
                            </span>
                        @endif
                    </td>
                </tr>
                @php $no++; @endphp
            @endforeach
        </tbody>
    </table>
    {{ $reqs->links() }}
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let formToDelete = null;
        function confirmDelete(event) {
            event.preventDefault();
            formToDelete = event.target.closest('form');
            $('#confirm').modal('show');
            
            return false;
        }
        document.getElementById('confirm-delete-btn').addEventListener('click', function() {
            if (formToDelete) {
                formToDelete.submit();
            }
        });
        const deleteButtons = document.querySelectorAll('.delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', confirmDelete);
        });
    });
    function confirmDelete(event) {
        event.preventDefault();
        const formToDelete = event.target.closest('form');
        if (typeof jQuery !== 'undefined' && jQuery.fn.modal) {
            $('#confirm').modal('show');
            $('#confirm-delete-btn').off('click').on('click', function() {
                formToDelete.submit();
            });
        } else {
            if (confirm('Are you sure you want to delete?')) {
                formToDelete.submit();
            }
        }
        
        return false;
    }
</script>
@endsection
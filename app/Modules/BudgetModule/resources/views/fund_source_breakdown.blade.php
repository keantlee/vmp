@extends('global.base')
@section('title', "Budget | Fund Monitoring and Disbursement")

{{--  import in this section your css files--}}
@section('page-css')
<link href="/assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
<link href="/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
@endsection




{{--  import in this section your javascript files  --}}
@section('page-js')
<script src="/assets/plugins/gritter/js/jquery.gritter.js"></script>
<script src="/assets/plugins/bootstrap-sweetalert/sweetalert.min.js"></script>
<script src="/assets/js/demo/ui-modal-notification.demo.min.js"></script>
<script src="/assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<script src="/assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="/assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src = "/assets/js/demo/table-manage-default.demo.min.js" ></script> 
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">

    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax:  {
                url: $(location).attr('href')
            },
            columns: [
                {data: 'fund_name', name: 'fund_name'},
                {data: 'reference_no', name: 'reference_no'},
                {data: 'supplier_name', name: 'supplier_name'},
                {data: 'description', name: 'description'},
                {data: 'quantity', name: 'quantity'},
                {data: 'amount', name: 'amount'},
                {data: 'total_amount', name: 'total_amount', orderable: true, searchable: true},
            ]
        });
    });
</script>
@endsection


<script>

</script>


@section('content')
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
    <li class="breadcrumb-item"><a href="{{ route('fund_moni_and_disb') }}">Fund monitoring and disbursement</a></li>
    <li class="breadcrumb-item active">Fund source breakdown</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
{{-- <h1 class="page-header">Blank Page <small>header small text goes here...</small></h1> --}}
<!-- end page-header -->
<!-- begin panel -->
<div class="panel panel-inverse mt-5">
    <div class="panel-heading">
        <h4 class="panel-title">Fund Source Breakdown</h4>
    </div>
    <div class="panel-body">
        <table id="yajra-datatable" class="table table-striped table-bordered text-center mt-5">            
            <thead>
                <tr>      
                    <th> Fund Source </th>              
                    <th> Reference No. </th>
                    <th> Supplier </th>
                    <th> Program </th>
                    <th> Quantity </th>
                    <th> Amount </th>
                    <th> Total Amount </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<!-- end panel -->
@endsection
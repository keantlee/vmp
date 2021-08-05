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

        var table = $('#fund_source_breakdown_tbl').DataTable({
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
                {data: 'amount', name: 'amount', render: $.fn.dataTable.render.number( ',', '.', 2, '&#8369;'  ).display},
                {data: 'total_amount', name: 'total_amount', render: $.fn.dataTable.render.number( ',', '.', 2, '&#8369;'  ).display, orderable: true, searchable: true},
            ],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
    
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\₱,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // quantity column[4]: get it's total sum
                total_quantity = api
                        .column( 4 )
                        .data()
                        .reduce( function (a, b) {
                                    return (a)*1 + (b)*1;}, 0 );
                        $( api.column( 4 ).footer() ).html("Total quantity:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+$.fn.dataTable.render.number(',', '.').display(total_quantity) );

                // amount column[5]: get it's total sum
                total_amount = api
                        .column( 5 )
                        .data()
                        .reduce( function (a, b) {
                                    return (a)*1 + (b)*1;}, 0 );
                        $( api.column( 5 ).footer() ).html("Total amount:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+$.fn.dataTable.render.number(',', '.', 2, '&#8369;').display(total_amount) );

                // Total amount column[6]: get it's total sum
                total_amount_of_voucher = api
                        .column( 6 )
                        .data()
                        .reduce( function (a, b) {
                                    return (a)*1 + (b)*1;}, 0 );
                        $( api.column( 6 ).footer() ).html("Total amount of voucher:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+$.fn.dataTable.render.number(',', '.', 2, '&#8369;').display(total_amount_of_voucher) );
            }
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
        <table id="fund_source_breakdown_tbl" class="table table-striped table-bordered table-hover text-center mt-5">            
            <thead style="background-color: #008a8a">
                <tr>      
                    <th style="color: white"> Fund Source </th>              
                    <th style="color: white"> Reference No. </th>
                    <th style="color: white"> Supplier </th>
                    <th style="color: white"> Program </th>
                    <th style="color: white"> Quantity </th>
                    <th style="color: white"> Amount </th>
                    <th style="color: white"> Total Amount </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tfoot>
        </table>
    </div>
</div>
<!-- end panel -->
@endsection
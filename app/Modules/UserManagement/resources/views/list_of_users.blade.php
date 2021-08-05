@extends('global.base')
@section('title', "User Management | List of Users")




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
	<script src="/assets/js/demo/table-manage-default.demo.min.js"></script>
	<script type="text/javascript">
		$(function() {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			var table = $('#user-datatable').DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{route('user.show')}}",
				columns: [
					{data: 'fullname_column', name: 'fullname_column'},
					{data: 'agency_shortname', name: 'agency_shortname'},
					{data: 'reg_prov_column', name: 'reg_prov_column'},
					{data: 'action', name: 'action', orderable: true, searchable: true},
				]
			});
		});

		$(document).on('click', '#btn_data', function () {
            $('#prog_description').text($(this).data('description'));
            $('#prog_email').text($(this).data('email'));
            $('#prog_contact_no').text($(this).data('contact_no'));
            $('#prog_role').text($(this).data('role'));
		});
	</script>
@endsection




<script>
    
</script>





@section('content')
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
    <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
    <li class="breadcrumb-item"><a href="javascript:;">Page Options</a></li>
    <li class="breadcrumb-item active">Blank Page</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Blank Page <small>header small text goes here...</small></h1>
<!-- end page-header -->

<!-- begin panel -->
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Panel Title here</h4>
    </div>
    <div class="panel-body">
        <br>
        <br><br>
        <table id="user-datatable" class="table table-striped table-bordered table-hover text-center">            
            <thead style="background-color: #008a8a">
                <tr>                    
                    <th style="color: white">Fullname</th>
                    <th style="color: white">Agency</th>
                    <th style="color: white">Region - Province</th>                    
                    <th style="color: white">Program</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

         <!-- #modal-view -->
         <div class="modal fade" id="ViewModal">
            <div class="modal-dialog modal-lg" style="max-width: 30%">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #008a8a">
                        <h4 class="modal-title" style="color: white">Intervention Program</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white">×</button>
                    </div>
                    <div class="modal-body">
                        {{--modal body start--}}
                        {{-- <h2 id="ViewCategName" align="center"></h2> --}}
                        {{-- <label style="display: block; text-align: center">(Insert Title here) Intervention program na abot ni supplier</label> --}}

                        <table id="interv-table"class="table table-bordered table-hover mt-5 mb-5 text-center">
                            <thead class="bg-success">
                              <tr>
                                <th scope="col" style="color: white">Program</th>
                                <th scope="col" style="color: white">Email</th>
                                <th scope="col" style="color: white">Contact No.</th>
                                <th scope="col" style="color: white">Role</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr style="font-size:13px">
                                <td><p id="prog_description"></td>
                                <td><p id="prog_email"></td>
                                <td><p id="prog_contact_no"></td>
                                <td><p id="prog_role"></td>
                              </tr>
                            </tbody>
                        </table>
                        {{--modal body end--}}
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end panel -->
@endsection
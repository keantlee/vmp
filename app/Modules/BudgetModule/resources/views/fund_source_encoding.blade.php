@extends('global.base')
@section('title', "Budget | Fund Source Encoding")

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

{{-- Dynamic dropdown --}}
<script>
    $(document).ready(function () {
        $('#select_province').append('<option value="">-- Select Province --</option>').prop('disabled', true);
        $('#select_region').on('change', function () {
            var reg_code = $(this).val();
            if (reg_code) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/budget/fund-source-encoding/' + reg_code,
                    type: "GET",
                    dataType: "json",
                    success: function (provinces) {
                        // console.log(provinces);
                        if (provinces) {
                            $('select[name="select_province"]').empty();
                            $('select[name="select_province"]').focus;
                            $('select[name="select_province"]').append('<option value="">-- Select Province --</option>');
                            $.each(provinces, function (key, province) {
                                $('select[name="select_province"]').append('<option value="' + province.prov_code + '">' + province.prov_name + ' </option>').prop('disabled', false).prop('selected', true);
                            }); 
                        } else {
                            $('#select_province').empty();
                        }
                    }
                });
            } else {
                $('#select_province').empty();
            }
        });
    }); 
</script>

{{-- Fund encoding - ORS validation form --}}
<script>
    $('#fund_encoding_ors').ready(function(){
		$('#fund_encoding_ors').validate({
			errorClass: "invalid",
   			validClass: "valid",
			rules: {
                select_program: {
                    required: true,
                },
                uacs: {
                    required: true,
                },
                amount: {
                    required: true,
                },
                select_region: {
                    required: true,
                },
                select_province: {
                    required: true,
                },
                particulars: {
                    required: true,
                },
			},
			messages: {
                select_program: '<div class="text-danger">*Please select a program!</div>',
				uacs: '<div class="text-danger">*The UACS field is required!</div>',
                select_region: '<div class="text-danger">*Please select a region!</div>',
                select_province: '<div class="text-danger">*Please select a province!</div>',
				amount: '<div class="text-danger">*The Amount field is required!</div>',
                particulars: '<div class="text-danger">*The particulars field is required!</div>',
			}, 
			// Customize placement of created message error labels. 
			errorPlacement: function(error, element) {
				error.appendTo( element.parent().find(".error_msg") );
				$('span.error_form').remove();
        	}
		});
	});
    $(document).on('submit', 'form#fund_encoding_ors', function(e){
		e.preventDefault();

		var route = "{{ route('submit_encoding_form') }}";
        
		var form_data = $(this);

		$.ajax({
			headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        	},
			method: 'POST',
			url: route,
			data: form_data.serialize(),
			success: function(success_response){
				Swal.fire({
					position: 'center',
					icon: 'success',
					title: success_response.message,
					showConfirmButton: true,
					// timer: 1500
				}).then(function(){ 
					window.location.href = "{{route('fund_encoding')}}";
				});
          	},
		});
	});
</script>
<script>
    // Jquery Dependency
    $("input#amount").on({keyup: function () {
        formatCurrency($(this));
    },
    blur: function () {
        formatCurrency($(this), "blur");
    }
    });

    function formatNumber(n) {
    // format number 1000000 to 1,234,567
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function formatCurrency(input, blur) {
    // appends $ to value, validates decimal side
    // and puts cursor back in right position.

    // get input value
    var input_val = input.val();

    // don't validate empty input
    if (input_val === "") {
        return;
    }

    // original length
    var original_len = input_val.length;

    // initial caret position
    var caret_pos = input.prop("selectionStart");

    // check for decimal
    if (input_val.indexOf(".") >= 0) {
        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        var decimal_pos = input_val.indexOf(".");

        // split number by decimal point
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);

        // add commas to left side of number
        left_side = formatNumber(left_side);

        // validate right side
        right_side = formatNumber(right_side);

        // On blur make sure 2 numbers after decimal
        if (blur === "blur") {
        right_side += "00";
        }

        // Limit decimal to only 2 digits
        right_side = right_side.substring(0, 2);

        // join number by .
        input_val = "$" + left_side + "." + right_side;
    } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        input_val = formatNumber(input_val);
        input_val = "₱" + input_val;

        // final formatting
        if (blur === "blur") {
        input_val += ".00";
        }
    }

    // send updated string to input
    input.val(input_val);

    // put caret back in the right position
    var updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    input[0].setSelectionRange(caret_pos, caret_pos);
    }
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

<!-- begin page-header -->
<h1 class="page-header">Blank Page <small>header small text goes here...</small></h1>

<!-- begin panel -->
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Fund Source Encoding - OBLIGATION REQUEST AND STATUS (ORS)</h4>
    </div>
    <div class="panel-body">
        <form id="fund_encoding_ors" method="POST" action="{{route('submit_encoding_form')}}" class="form-control-with-bg">
            {{ csrf_field() }}
            <span class="error_form"></span>
            <!-- begin row -->
            <div class="row">
                <!-- begin col-8 -->
                <div class="col-md-8 offset-md-2">
                    <div class="form-group row m-b-10">
                        <label class="col-md-3 text-md-right col-form-label">Program</label>
                        <div class="col-md-6">
                            <select class="form-control" name="select_program" id="select_program">
                                <option value="">-- Select program --</option>
                                @foreach ($programs as $program)
                                    <option value="{{$program->program_id}}">{{$program->description}}</option>
                                @endforeach
                            </select>
                            <span class="error_msg"></span>
                        </div>
                    </div>

                    <div class="form-group row m-b-10">
                        <label class="col-md-3 text-md-right col-form-label">UACS</label>
                        <div class="col-md-6">
                            <input type="number" name="uacs" placeholder="input uacs..." class="form-control" />
                            <span class="error_msg"></span>
                        </div>
                    </div>

                    <div class="form-group row m-b-10">
                        <label class="col-md-3 text-md-right col-form-label">Region</label>
                        <div class="col-md-6">
                            <select class="form-control" name="select_region" id="select_region">
                                <option value="">-- Select region --</option>
                                @foreach ($regions as $region)
                                    <option value="{{$region->reg_code}}">{{$region->reg_name}}</option>
                                @endforeach
                            </select>
                            <span class="error_msg"></span>
                        </div>
                    </div>

                    {{-- <div class="form-group row m-b-10">
                        <label class="col-md-3 text-md-right col-form-label">Province</label>
                        <div class="col-md-6">
                            <select class="form-control" name="select_province" id="select_province">
                            </select>
                            <span class="error_msg"></span>
                        </div>
                    </div> --}}

                    <div class="form-group row m-b-10">
                        <label class="col-md-3 text-md-right col-form-label">Amount</label>
                        <div class="col-md-6">
                            <input id="amount" type="text" name="amount" placeholder="0.00" class="form-control" />
                            <span class="error_msg"></span>
                        </div>
                    </div>

                    <div class="form-group row m-b-10">
                        <label class="col-md-3 text-md-right col-form-label">Particulars</label>
                        <div class="col-md-6">
                            <textarea class="form-control" rows="3" name="particulars"></textarea>
                            <span class="error_msg"></span>
                            <br>
                            <button type="submit" class="btn btn-block btn-outline-success">Submit</button>
                        </div>
                    </div>
                </div>
                <!-- end col-8 -->
            </div>
            <!-- end row -->
        </form>
    </div>
</div>
<!-- end panel -->
@endsection
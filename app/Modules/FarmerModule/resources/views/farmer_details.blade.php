@extends('global.base')
@section('title', "Farmers | List of Details")

{{--  import in this section your css files--}}
@section('page-css')
<link href="/assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
<link href="/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
{{-- Datatables --}}
<link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.1.3/css/rowGroup.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

<link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.css">
<link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">

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
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.min.js"></script>

{{-- Datatables --}}
<script src="//cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

{{-- //cdn.datatables.net/responsive/2.2.9/js/responsive.dataTables.js
//cdn.datatables.net/responsive/2.2.9/js/responsive.dataTables.min.js --}}

<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

<script src="https://cdn.datatables.net/rowgroup/1.1.3/js/dataTables.rowGroup.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.2/handlebars.min.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Interventions and Location row details on datatable --}}
<script>
    function template ( d ) {
        return '<table class="table table-bordered">'+
                 // image interventions
                 '<tr>'+
                    '<td>Interventions:</td>'+
                    '<td>'+
                        '<div class="container__img-holder">'+
                            '<img src="https://images.unsplash.com/photo-1609342122563-a43ac8917a3a?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=240&q=80">'+
                        '</div>'+
                        '<div class="container__img-holder">'+
                            '<img src="https://images.unsplash.com/photo-1609342122563-a43ac8917a3a?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=240&q=80">'+
                        '</div>'+
                        '<div class="container__img-holder">'+
                            '<img src="https://images.unsplash.com/photo-1609342122563-a43ac8917a3a?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=240&q=80">'+
                        '</div>'+
                    '</td>'+
                 '</tr>'+ 
                 // Map Location
                 '<tr>'+
                    '<td>Location:</td>'+
                    '<td>'+
                        '<div class="row">'+
                            '<div class="col-md-12 modal_body_map">'+
                                // '<div id="map_canvas">'+
                                // '</div>'+
                                '<iframe id="map_canvas" width="600" height="450" style="border:0" loading="lazy" allowfullscreen src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDWqPBqSNqsriXUgiXJ1h-xd2a7J71BpP4&q='+d.latitude+'+'+d.longitude+'"></iframe>'+
                            '</div>'+
                        '</div>'+
                    '</td>'+
                 '</tr>'+   
            '</table>';
    }       
</script>
<script>
    // image intervention clicking function: 
    $(document).on('click', '.container__img-holder', function(){
        var img_src = $(this).children('img').attr('src');
        imgWindow = window.open(img_src, 'imgWindow');
    });
</script>

<script>
    // Multiple Markers on Database
    // var location_markers = {!! json_encode( $markers ) !!};
    function initMap(){}

    $(() => {
        let map = document.getElementById("map_canvas");
        
        initMap = function() {
            // Create new bounds based on a southwest and a northeast corner
            var bounds = new google.maps.LatLngBounds();

            // mapOptions like "zoom, OR type of map: [1] roadmap, [2] satellite"
            var mapOptions = {
                mapTypeId: "satellite",
                zoomControl: true,
            };
    
            // Display a map on the page
            map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
            
            // setTilt ->
            map.setTilt(45);

            var greenIconMarker = {
                url: "http://maps.google.com/mapfiles/ms/icons/green-dot.png"
            };
            var redIconMarker = {
                url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png"
            };

            var customIconMarker = 31;
            console.log('asdas');
            for (let i = 0; i < location_markers.length; i++) {
                try {
                    if(location_markers[i].voucher_details_id == "75db5f14-3343-435d-9310-0530ba815b19"){
                    // console.log(location_markers[i].latitude);
                    var loc_LatLong = new google.maps.LatLng(location_markers[i].latitude, location_markers[i].longitude);
                    //  Extend the bounds with the last marker position
                    bounds.extend(loc_LatLong);

                    var title = location_markers[i].name;

                    var marker = new google.maps.Marker({
                        position: loc_LatLong,
                        map: map,
                        title: title,
                        icon: greenIconMarker
                    });

                    // Info Window Content
                    var contentString =
                        '<div id="markerContent">' +
                        "<p><b>Voucher details id: </b>" + location_markers[i].voucher_details_id + "</p>" +
                        '<h1 id="contentHeading" class="contentHeading">' + location_markers[i].reference_no + "</h1>" +
                        "<p><b>Supplier: </b>" + location_markers[i].supplier_id + "</p>" +
                        "<p><b>Fund Source: </b>" + location_markers[i].fund_id + "</p>" +
                        "<p><b>Program: </b>" + location_markers[i].sub_program_id + "</p>" +
                        "<p><b>Latitude: </b>" + location_markers[i].latitude + "</p>" +
                        "<p><b>Longitude: </b>" + location_markers[i].longitude + "</p>" +
                        "<p><b>Status: </b>" + "null" + "</p>" +
                        "</div>";

                    // Allow each marker to have an infoWindow
                    var infowindow = new google.maps.InfoWindow();
                    google.maps.event.addListener(
                        marker,
                        "click",
                        (function (marker, contentString, infowindow) {
                            return function () {
                                infowindow.setContent(contentString);
                                infowindow.open(map, marker);
                            };
                        })(marker, contentString, infowindow)
                    );

                    /** Automatically center the map fitting all markers on the screen and
                    * display the area between the location southWest and northEast.
                    **/

                    map.fitBounds(bounds);
                    }

                } catch (err) {
                    console.log("No location found on database!");
                }
            }
        }
    });  
</script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.45&key=AIzaSyC6JVpfd5wzUy4nYmymW1OTpuhSMbTkBe8&callback=initMap" ></script>

{{-- Datatable of farmer details --}}
<script>
    $(document).ready(function () {       
        var route = $(location).attr('href');

        // var template = Handlebars.compile($("#details-template").html());
        var table = $('#farmer-details-datatable').DataTable({
            destroy:true,
            processing: true,
            serverSide: true,
            responsive: true,
            "paging": false,
            ajax: { url: route},
            dom: 'Bfrtip',
            buttons: [
                { extend: 'csv', footer: true },
                { extend: 'excel', footer: true },
                { extend: 'pdf', footer: true },
                { extend: 'print', footer: true }
            ],
            columns: [
                {
                    "className":      'details-control',
                    "targets":         [ 1 ],
                    "orderable":      false,
                    "searchable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                // {data: 'voucher_details_id', name: 'voucher_details_id'},
                {data: 'reference_no', name: 'reference_no'},
                {data: 'fullname_column', name: 'fullname_column'},
                {data: 'description', name: 'description'},
                {data: 'quantity', name: 'quantity'},
                {data: 'amount', name: 'amount', render: $.fn.dataTable.render.number( ',', '.', 2, '&#8369;'  ).display},
                {data: 'total_amount', name: 'total_amount', render: $.fn.dataTable.render.number( ',', '.', 2, '&#8369;'  ).display},
                {data: 'tansac_by_fullname', name: 'tansac_by_fullname'},
                {data: 'payout_date', name: 'payout_date', orderable: true, searchable: true},
            ],
            "columnDefs": [
                            { "visible": false, "targets": 3 }
                          ],
            "order": [[ 3, 'asc' ]],
            "displayLength": 25,
            "drawCallback": function ( settings) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;
                var column = [3];

                api.column(3, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="bg-success text-light"><td colspan="8">'+group+'</td></tr>'
                        );
    
                        last = group;
                    }
                });
            },
            order: [[3, 'asc']],
            rowGroup: {
                startRender: null,
                endRender: function ( rows, group ) {
                    var total_amount_claim = rows
                        .data()
                        .pluck('total_amount')
                        .reduce( function (a, b) {
                                    return (a)*1 + (b)*1;
                        }, 0 );
                    total_amount_claim = $.fn.dataTable.render.number(',', '.', 2, '&#8369;').display( total_amount_claim );
    
                    return $('<tr/>')
                        // .append( '<td colspan="3" class="text-left">'+group+'</td>' )
                        .append( '<td colspan="8" class="text-left">Total amount claim:&nbsp;&nbsp;&nbsp;'+total_amount_claim+'</td>' )
                },
                dataSrc: function (data) {
                return data.description;}
            },
        });
        var detailRows = [];
        // Add event listener for opening and closing row details of datatable
        $('#farmer-details-datatable tbody').on('click', 'td.details-control', function () {
            // var user_refno = $(this).closest("tr").find("td:eq(1)").text();
            // console.log(user_refno);

            var tr = $(this).closest('tr');
            var row = table.row( tr );
            var idx = $.inArray( tr.attr('id'), detailRows );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                tr.removeClass('shown');
                row.child.hide();
            }
            else {
                // Open this row
                tr.addClass('shown');
                row.child(template(row.data())).show();
                // Add to the 'open' array
                if ( idx === -1 ) {
                    detailRows.push( tr.attr('id') );
                }
            }
        });

        // On each draw, loop over the `detailRows` array and show any child rows
        table.on( 'draw', function () {
            $.each( detailRows, function ( i, id ) {
                    $('#'+id+' td.details-control').trigger( 'click' );
                } );
            } );
        });
</script>
@endsection


<script>

</script>


@section('content')

<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
    <li class="breadcrumb-item"><a href="{{ route('farmer.main') }}">Farmers List</a></li>
    <li class="breadcrumb-item active">Farmer Details</li>
</ol>

<!-- begin page-header -->
<h1 class="page-header">Add farmer Fullname <small>Add RSBSA NO.</small></h1>


<!-- begin panel -->
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Panel Title here</h4>
    </div>
    <div class="panel-body">
        <br>
        <br><br>

        <table id="farmer-details-datatable" class="table table-bordered text-center mb-5 display" style="width:100%">
            <thead>
                <tr>
                    <th></th>
                    {{-- <th>Voucher Details ID</th> --}}
                    <th>Reference No.</th>
                    <th>Full name</th>
                    <th>Program</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                    <th>Total Amount</th>
                    <th>Transact By</th>
                    <th>Payout Date</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        
        {{-- <div id="map_canvas" hidden>
        </div> --}}

        {{-- Fetch all location_markers using show_marker_controller.php from the database  --}}
        <script> var location_markers = {!!json_encode($markers) !!}; </script>
    </div>
</div>
@endsection
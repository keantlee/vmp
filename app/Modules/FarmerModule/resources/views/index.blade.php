@extends('global.base')
@section('title', "Farmers | List")

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
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.min.js"></script>

<script src="//cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.2/handlebars.min.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}&callback=initMap" async defer></script> --}}

{{-- <script>
    // Multiple Markers on Database
    // var location_markers = {!! json_encode( $markers ) !!};

    var map = null;
    
    function initMap() {

        // Create new bounds based on a southwest and a northeast corner
        var bounds = new google.maps.LatLngBounds();

        // mapOptions like "zoom, OR type of map: [1] roadmap, [2] satellite"
        var mapOptions = {
            mapTypeId: "satellite"
        };

        // Display a map on the page
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);
        // setTilt ->
        map.setTilt(45);

        var greenIconMarker = {
            url: "http://maps.google.com/mapfiles/ms/icons/green-dot.png"
        };
        var redIconMarker = {
            url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png"
        };
        var customIconMarker = 31;

        for (let i = 0; i < location_markers.length; i++) {
            try {
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
                    "<p id='site_id' data-id='" + location_markers[i].fund_id + "' hidden>' </p>" +
                    '<h1 id="contentHeading" class="contentHeading">' + location_markers[i].reference_no + "</h1>" +
                    "<p><b>Supplier: </b>" + location_markers[i].supplier_id + "</p>" +
                    "<p><b>Fund Source: </b>" + location_markers[i].fund_id + "</p>" +
                    "<p><b>Program: </b>" + location_markers[i].sub_program_id + "</p>" +
                    "<p><b>Address: </b>" + location_markers[i].address + "</p>" +
                    "<p><b>Latitude: </b>" + location_markers[i].latitude + "</p>" +
                    "<p><b>Longitude: </b>" + location_markers[i].longitude + "</p>" +
                    "<p><b>Status: </b>" + "null" + "</p>" +
                    // "<a href='/dashboard/site_datalog"+  "/" + location_markers[i].id + " ' " + "class='view_btn_site btn btn-outline-primary btn-sm' id='view_btn_site'>View</a>"
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
            } catch (err) {
                console.log("No location found on database!");
            }
        }
    }
    //Re-init map before show modal
    $('#ViewFarmerDetailsModal').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget);
      initMao(button.data('lat'), button.data('lng'));
    });
</script> --}}

<script type="text/javascript">
    $(document).ready(function(){
        var table = $('#farmer-datatable').DataTable({
            processing: true,
            serverSide: true,
            // responsive: true,
            responsivePriority: 1,
            ajax: "{{route('farmer.main')}}",
            columns: [
                {data: 'reference_no', name: 'reference_no'},
                {data: 'fullname_column', name: 'fullname_column'},
                {data: 'action', name: 'action', orderable: true, searchable: true},
            ]
        }); 
    });
</script>
@endsection


<script>

</script>


@section('content')
{{-- <input type="hidden" id="refno" value="1"> --}}
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

<div class="row">
    <!-- begin col-3 -->
    <div class="col-lg-3 col-md-6">
        <div class="widget widget-stats bg-gradient-green">
            <div class="stats-icon stats-icon-lg"><i class="fa fa-globe fa-fw"></i></div>
            <div class="stats-content">
                <div class="stats-title" style="font-size: 15px">RRP2 DRY SEASON 2021  (TOTAL CLAIMED) :</div>
                <div class="stats-number">7,842,900</div>
                <div class="stats-progress progress">
                    <div class="progress-bar" style="width: 70.1%;"></div>
                </div>
                <div class="stats-desc">Better than last week (70.1%)</div>
            </div>
        </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-lg-3 col-md-6">
        <div class="widget widget-stats bg-gradient-blue">
            <div class="stats-icon stats-icon-lg"><i class="fa fa-dollar-sign fa-fw"></i></div>
            <div class="stats-content">
                <div class="stats-title" style="font-size: 15px">RRP2 WET SEASON 2021 (TOTAL CLAIMED) :</div>
                <div class="stats-number">180,200</div>
                <div class="stats-progress progress">
                    <div class="progress-bar" style="width: 40.5%;"></div>
                </div>
                <div class="stats-desc">Better than last week (40.5%)</div>
            </div>
        </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-lg-3 col-md-6">
        <div class="widget widget-stats bg-gradient-purple">
            <div class="stats-icon stats-icon-lg"><i class="fa fa-archive fa-fw"></i></div>
            <div class="stats-content">
                <div class="stats-title" style="font-size: 15px">CASH AND FOOD 2021 (TOTAL CLAIMED) :</div>
                <div class="stats-number">38,900</div>
                <div class="stats-progress progress">
                    <div class="progress-bar" style="width: 76.3%;"></div>
                </div>
                <div class="stats-desc">Better than last week (76.3%)</div>
            </div>
        </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-lg-3 col-md-6">
        <div class="widget widget-stats bg-gradient-black">
            <div class="stats-icon stats-icon-lg"><i class="fa fa-comment-alt fa-fw"></i></div>
            <div class="stats-content">
                <div class="stats-title" style="font-size: 15px">TOTAL OF VOUCHERS NOT YET CLAIMED : </div>
                <div class="stats-number">3,988</div>
                <div class="stats-progress progress">
                    <div class="progress-bar" style="width: 54.9%;"></div>
                </div>
                <div class="stats-desc">Better than last week (54.9%)</div>
            </div>
        </div>
    </div>
    <!-- end col-3 -->
</div>
<!-- end row -->

<!-- begin panel -->
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Panel Title here</h4>
    </div>
    <div class="panel-body">
        <br>
        <br><br>
        <table id="farmer-datatable" class="table table-striped table-bordered text-center">
            <thead style="background-color: #008a8a">
                <tr>
                    <th style="color: white">Reference No.</th>
                    <th style="color: white">Fullname</th>
                    <th style="color: white">View farmer details</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection

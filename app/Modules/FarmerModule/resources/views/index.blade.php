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

{{-- <script id="details-template" type="text/x-handlebars-template">
  <table class="table">
      <tr>
          <td>Interventions:</td>
          <td>
            <div class="container__img-holder">
              <img src="https://images.pexels.com/photos/459225/pexels-photo-459225.jpeg?auto=compress&cs=tinysrgb&h=750&w=1260" alt="Image">
            </div>
            <div class="container__img-holder">
              <img src="https://images.pexels.com/photos/371589/pexels-photo-371589.jpeg?auto=compress&cs=tinysrgb&h=750&w=1260" alt="Image">
            </div>
            <div class="container__img-holder">
              <img src="https://images.pexels.com/photos/258109/pexels-photo-258109.jpeg?auto=compress&cs=tinysrgb&h=750&w=1260" alt="Image">
            </div>
            <div class="container__img-holder">
              <img src="https://images.pexels.com/photos/210186/pexels-photo-210186.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" alt="Image">
            </div>
            <div class="container__img-holder">
              <img src="https://images.pexels.com/photos/1903702/pexels-photo-1903702.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" alt="Image">
            </div>
            <div class="container__img-holder">
              <img src="https://images.pexels.com/photos/589697/pexels-photo-589697.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" alt="Image">
            </div>
            <div class="img-popup">
                <img src="" alt="Popup Image">
                <div class="close-btn">
                  <div class="bar"></div>
                  <div class="bar"></div>
                </div>
            </div>
          </div>
          </td>
      </tr>
      <tr>
          <td>Location:</td>
          <td>
            <div class="row">
              <div class="col-md-12 modal_body_map">
                <div class="location-map" id="location-map">
                  <div style="width: 600px; height: 400px;" id="map_canvas"></div>
                </div>
              </div>
            </div>
          </td>
      </tr>
  </table>
  <script>
    // image intervention: 
    $(document).ready(function() {
      // required elements
      var imgPopup = $('.img-popup');
      var imgCont  = $('.container__img-holder');
      var popupImage = $('.img-popup img');
      var closeBtn = $('.close-btn');
  
      // handle events
      imgCont.on('click', function() {
        var img_src = $(this).children('img').attr('src');
        imgPopup.children('img').attr('src', img_src);
        imgPopup.addClass('opened');
      });
  
      $(imgPopup, closeBtn).on('click', function() {
        imgPopup.removeClass('opened');
        imgPopup.children('img').attr('src', '');
      });
  
      popupImage.on('click', function(e) {
        e.stopPropagation();
      });
    });
  </script>

  <script>
    // Map Location
    var map = null;
    var myMarker;
    var myLatlng;
    var lat = 21.03;
    var lng = 105.85; 

    function initMap() {
      myLatlng = new google.maps.LatLng(lat, lng);

      var myOptions = {
        zoom: 12,
        zoomControl: true,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      };

      map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

      myMarker = new google.maps.Marker({
        position: myLatlng
      });
      myMarker.setMap(map);
    }
  </script>
</script>

<script>
      // Re-init map before show modal
      $('#ViewFarmerDetailsModal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      initMap(button.data('lat'), button.data('lng'));
      $("#location-map").css("width", "100%");
      $("#map_canvas").css("width", "100%");
    });

    // Trigger map resize event after modal shown
    $('#ViewFarmerDetailsModal').on('shown.bs.modal', function() {
      google.maps.event.trigger(map, "resize");
      map.setCenter(myLatlng);
    });
</script> --}}

<script>
    $(document).on('click', '#view_farmer_detail_btn', function () {       
        var ref_no = $(this).data('id');

        var route = '/farmer/view-details/'+ref_no;

        var template = Handlebars.compile($("#details-template").html());

        var table = $('#farmer-details-datatable').DataTable({
            destroy:true,
            processing: true,
            serverSide: true,
            responsive: true,
            "paging": false,
            ajax: { url: route},
            columns: [
              {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
              },
                {data: 'reference_no', name: 'reference_no'},
                {data: 'fullname_column', name: 'fullname_column'},
                {data: 'description', name: 'description'},
                {data: 'quantity', name: 'quantity'},
                {data: 'amount', name: 'amount'},
                {data: 'total_amount', name: 'total_amount'},
                {data: 'tansac_by_fullname', name: 'tansac_by_fullname'},
                {data: 'payout_date', name: 'payout_date', orderable: true, searchable: true},
            ],
            "order": [[1, 'asc']]
        });

        // Add event listener for opening and closing details
        $('#farmer-details-datatable tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );
            // var open = row.child.isShown();
            
            if ( row.child.isShown() ) {
                // This row is already open - close it
                tr.removeClass('shown');
                row.child.hide();
            }
            else {
                // close all previously opened rows
                // closeOpenedRows(table, tr);

                // Open this row
                row.child( template(row.data()) ).show();
                tr.addClass('shown');
               
                // store current selection
                // openRows.push(tr);
            }
        });
        $('#farmer-details-datatable').DataTable().ajax.reload();
    });
</script>
{{-- <script>
    var openRows = new Array();
    function closeOpenedRows(table, selectedRow) {
    $.each(openRows, function (index, openRow) {
        // not the selected row!
        if ($.data(selectedRow) !== $.data(openRow)) {
            var rowToCollapse = table.row(openRow);
            rowToCollapse.child.hide();
            openRow.removeClass('shown');
            // replace icon to expand
            $(openRow).find('td.details-control').html('<span class="glyphicon glyphicon-plus"></span>');
            // remove from list
            var index = $.inArray(selectedRow, openRows);
            openRows.splice(index, 1);
        }
    });
}
</script> --}}
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
                <div class="stats-title">TODAY'S VISITS</div>
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
                <div class="stats-title">TODAY'S PROFIT</div>
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
                <div class="stats-title">NEW ORDERS</div>
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
                <div class="stats-title">NEW COMMENTS</div>
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
        {{-- <button id="open" data-toggle="modal" data-target="#viewmapmap">showMap</button> --}}
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-lat='21.03' data-lng='105.85'>
            Location 1
        </button>
        <h4 class="panel-title">Panel Title here</h4>
    </div>
    <div class="panel-body">
        <br>
        <br><br>
        <table id="farmer-datatable" class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                    <th>Reference No.</th>
                    <th>Fullname</th>
                    <th>View farmer details</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<!-- #modal-view -->
<div class="modal fade" id="ViewFarmerDetailsModal">
    <div class="modal-dialog modal-lg" style="max-width: 80%">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #008a8a">
                <h4 class="modal-title" style="color: white">View Category</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                    style="color: white">×</button>
            </div>
            <div class="modal-body">
                {{--modal body start--}}
                <h2 id="ViewCategName" align="center"></h2>
                <label style="display: block; text-align: center">Sample</label>

                <table id="farmer-details-datatable" class="table table-striped table-bordered text-center mb-5 display" style="width:100%">
                    <thead>
                        <tr>
                            <th><span id="icon"></span></th>
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
                <div class="row">
                    {{-- <div class="row">
                      <div class="col-md-12 modal_body_map">
                        <div class="location-map" id="location-map">
                          <div style="width: 600px; height: 400px;" id="map_canvas"></div>
                        </div>
                      </div>
                    </div> --}}
                </div>

                {{-- Map location of claiming intervention --}}
                {{-- <div id="map">
                </div> --}}
                {{-- Fetch all location_markers using show_marker_controller.php from the database  --}}
                {{-- <script> var location_markers = {!!json_encode($markers) !!}; </script> --}}
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>
@endsection

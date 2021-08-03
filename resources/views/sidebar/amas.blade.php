<!-- begin sidebar nav -->
<ul class="nav">
    <li class="nav-header">Navigation</li>
    <li class="">
        <a href="{{ route('main.home') }}">					        
            <i class="fa fa-th-large"></i>
            <span>Dashboard</span>
        </a>        
    </li>
    {{-- <li class="{{Route::currentRouteName() == 'user.index' ? 'active' : null}}">
        <a href="{{ route('user.index') }}">					        
            <i class="fa fa-th-large"></i>
            <span>User Management</span>
        </a>        
    </li> --}}
    <li class="has-sub {{Route::currentRouteName() == 'user.index' ? 'active' : null}}">
        <a href="javascript:;">
            <b class="caret"></b>
            <i class="fa fa-th-large"></i>
            <span>User Management</span> 
        </a>
        <ul class="sub-menu">
            <li class="">
                <a href="#">List of users</a>
            </li>
        </ul>
    </li>
    <li class="has-sub {{Route::currentRouteName() == 'farmer.main' ? 'active' : null}}">
        <a href="{{route('farmer.main')}}">
            <b class="caret"></b>
            <i class="fa fa-th-large"></i>
            <span>Farmers List</span> 
        </a>
        {{-- <ul class="sub-menu">
            <li class="">
                <a href="#">List of users</a>
            </li>
        </ul> --}}
    </li>
    <li class="has-sub {{(Route::currentRouteName() == 'fund_encoding' || Route::currentRouteName() == 'fund_moni_and_disb') ? 'active' : null}}">
        <a href="javascript:;">
            <b class="caret"></b>
            <i class="fa fa-th-large"></i>
            <span>Budget</span> 
        </a>
        <ul class="sub-menu">
            <li class="{{Route::currentRouteName() == 'fund_encoding' ? 'active' : null}}">
                <a href="{{route('fund_encoding')}}">Fund Source Encoding</a>
            </li>
            <li class="{{Route::currentRouteName() == 'fund_moni_and_disb' ? 'active' : null}}">
                <a href="{{route('fund_moni_and_disb')}}">Fund monitoring and disbursement</a>
            </li>
        </ul>
    </li>
    <li class="has-sub">
        <a href="javascript:;">
            <b class="caret"></b>
            <i class="fa fa-th-large"></i>
            <span>Reports</span> 
        </a>
        <ul class="sub-menu">
            <li class="">
                <a href="#">List of users</a>
            </li>
        </ul>
    </li>
    
    {{-- <li class="has-sub">
        <a href="javascript:;">
            <b class="caret"></b>
            <i class="fa fa-building"></i>
            <span>Voucher Management</span> 
        </a>
        <ul class="sub-menu">
            <li><a href="ui_general.html">Suppliers</a></li>						
            
        </ul>
    </li> --}}

    <!-- begin sidebar minify button -->
    <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
    <!-- end sidebar minify button -->
</ul>
<!-- end sidebar nav -->
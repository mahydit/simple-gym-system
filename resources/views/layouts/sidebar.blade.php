<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{Auth::User()->name}}</p>
                <!-- Status -->
                <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
            </div>
        </div>

        
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
        <li class="header"> </li>
            @hasrole('admin')
            <li class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>City Manager</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('cityManagers.create')}}">Create</a></li>
                    <li><a href="{{route('cityManagers.index')}}">View All</a></li>
                </ul>
            </li>
            @endhasrole

            @hasanyrole('citymanager|admin')
            <li class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>Gym Manager</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('gymManagers.create')}}">Create</a></li>
                    <li><a href="{{route('gymManagers.index')}}">View All</a></li>
                </ul>
            </li>
            @endhasanyrole

            @hasrole('admin')
            <li class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>City</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('cities.create')}}">Create</a></li>
                    <li><a href="{{route('cities.index')}}">View All</a></li>
                </ul>
            </li>
            @endhasrole

            @hasanyrole('citymanager|admin')
            <li class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>Gym</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('gyms.create')}}">Create</a></li>
                    <li><a href="{{route('gyms.index')}}">View All</a></li>
                </ul>
            </li>   
            @endhasanyrole

            <li class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>Training Packages</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @hasrole('admin')
                    <li><a href="{{route('packages.create')}}">Create</a></li>
                    @endhasrole
                    <li><a href="{{route('packages.index')}}">View All</a></li>
                </ul>
            </li>

            @hasrole('admin')
            <li class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>Coaches</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                        <li><a href="{{route('coaches.create')}}">Create</a></li>
                        <li><a href="{{route('coaches.index')}}">View All</a></li>
                    </ul>
                </li>
                @endhasrole
                
            <li class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>Sessions</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('sessions.create')}}">Create</a></li>
                    <li><a href="{{route('sessions.index')}}">View All</a></li>
                </ul>
            </li>
            
            <li><a href="{{route('attendances.index')}}"><i class="fa fa-link"></i> <span>Sessions' Attendance</span></a></li>
                
            
            <li><a href="{{route('purchases.index')}}"><i class="fa fa-link"></i> <span>Purchases History</span></a></li>

            <li><a href="{{route('revenues.index')}}"><i class="fa fa-link"></i> <span>Revenue</span></a></li>

            <li><a href="{{route('purchases.create')}}"><i class="fa fa-link"></i> <span>Buy Package</span></a></li>

        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>

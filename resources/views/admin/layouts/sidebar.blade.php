 <div class="app-sidebar__overlay" data-toggle="sidebar"></div>

    <aside class="app-sidebar">

          <?php

      $test = Auth::user()->image_name;

      ?>

      @if($test =="")

        <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image">      

      @else

      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" style="max-height: 100px; max-width: 100px;" src="<?php echo url("img/$test");?>" alt="User Image">

      @endif

          <p class="app-sidebar__user-name">{{Auth::user()->name}}</p>

          <p class="app-sidebar__user-designation">{{Auth::user()->email}}</p>

        </div>

      <ul class="app-menu">

        <!-- <li><a class="app-menu__item <?php if(Request::segment(1) == "dashboard") //echo "active"; ?>" href="{{url('/')}}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li> -->

        <li><a class="app-menu__item <?php if(Request::segment(1) == "users") //echo "active"; ?>" href="{{url('/site_admins')}}"><i class="app-menu__icon fa fa-user-tie"></i><span class="app-menu__label">Site Admins</span></a></li>

        <li><a class="app-menu__item <?php if(Request::segment(1) == "users") //echo "active"; ?>" href="{{url('/admin')}}"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Organization Admins</span></a></li>

        <!--<li><a class="app-menu__item <?php if(Request::segment(1) == "incident") echo "active"; ?>" href="{{url('/incident')}}"><i class="fa fa-info-circle"></i><span class="app-menu__label" style="padding-left: 10px;">Incident Register</span></a></li>-->
		
		<li><a class="app-menu__item <?php if(Request::segment(1) == "company") //echo "active"; ?>" href="{{url('/company')}}"><i class="app-menu__icon fas fa-copyright"></i><span class="app-menu__label">Organizations</span></a></li>
		<!--
        <li><a class="app-menu__item <?php if(Request::segment(1) == "selectClient") //echo "active"; ?>" href="{{url('selectClient')}}"><i class="app-menu__icon fa fa-gift"></i><span class="app-menu__label">Select Client</span></a></li>
		-->
		<!--
        <li><a class="app-menu__item <?php if(Request::segment(1) == "client") //echo "active"; ?>" href="{{url('client')}}"><i class="app-menu__icon fa fa-book"></i><span class="app-menu__label">Client</span></a></li>
		-->

        <li><a class="app-menu__item <?php if(Request::segment(1) == "question") //echo "active"; ?>" href="{{route('admin_forms_list')}}"><i class="app-menu__icon fa fa-tasks"></i><span class="app-menu__label">Manage Assessment Form</span></a></li>

        <!--<li><a class="app-menu__item <?php if(Request::segment(1) == "sar") //echo "active"; ?>" href="{{url('Forms/AdminFormsList/sar')}}"><i class="app-menu__icon fa fa-tasks"></i><span class="app-menu__label">SAR Form</span></a></li>-->


        <!--<li><a class="app-menu__item <?php if(Request::segment(1) == "assets") //echo "active"; ?>" href="{{route('asset_list')}}"><i class="app-menu__icon fa fa-list"></i><span class="app-menu__label">Assets List</span></a></li>-->
        
        <li><a class="app-menu__item <?php if(Request::segment(1) == "login_img_settings") //echo "active"; ?>" href="{{url('/login_img_settings')}}"><i class="app-menu__icon fa fa-list"></i><span class="app-menu__label">Logo Settings</span></a></li>
   

	<!--
     <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Reports</span><i class="treeview-indicator fa fa-angle-right"></i></a>

          <ul class="treeview-menu">

            <li><a class="treeview-item" href=""><i class="icon fa fa-circle-o"></i> Assets</a></li>
            <li><a class="treeview-item" href=""><i class="icon fa fa-circle-o"></i> Data Inventory</a></li>

          </ul>

    </li>
	-->
	
	<?php
			$expanded = '';
			if (strpos(url()->current(), 'AssetsReports') !== false || strpos(url()->current(), 'DataInvReports') !== false)
			{
				$expanded = 'is-expanded';	
			}
	?>
   <!--  <li class="{{"treeview ".$expanded}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Reports</span><i class="treeview-indicator fa fa-angle-right"></i></a>-->

   <!--       <ul class="treeview-menu">-->

   <!--         <li class="treeview-ex"><a class="app-menu__item" href="#" data-toggle="treeview-ex"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">External Users</span><i class="treeview-indicator fa fa-angle-right"></i></a>-->
			<!--	<ul class="treeview-menu">-->
			<!--		<li><a class="treeview-item" href="{{url('/Reports/AssetsReportsEx/')}}/1"><i class="icon fa fa-circle-o"></i> Assets</a></li>	-->
			<!--		<li><a class="treeview-item" href="{{url('/Reports/DataInvReportsEx/')}}/2"><i class="icon fa fa-circle-o"></i> Data Inventory</a></li>				-->
			<!--	</ul>-->
			<!--</li>-->

   <!--       </ul>-->
		  
   <!--       <ul class="treeview-menu">-->

   <!--         <li class="treeview-reg"><a class="app-menu__item" href="#" data-toggle="treeview-reg"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Company Users</span><i class="treeview-indicator fa fa-angle-right"></i></a>-->
			<!--	<ul class="treeview-menu">-->
			<!--		<li><a class="treeview-item" href="{{url('/Reports/AssetsReportsReg/')}}/1"><i class="icon fa fa-circle-o"></i> Assets</a></li>	-->
			<!--		<li><a class="treeview-item" href="{{url('/Reports/DataInvReportsReg/')}}/2"><i class="icon fa fa-circle-o"></i> Data Inventory</a></li>				-->
			<!--	</ul>-->
			<!--</li>-->

   <!--       </ul>		  -->

   <!-- </li>	-->

        <!--<div id="collapseSettings" class="collapse {{(strpos(url()->current(), 'login_img_settings') !== false)?'show':''}}" aria-labelledby="headingSetting" data-parent="#accordionSidebar">-->
        <!--    <div class="bg-white py-2 collapse-inner rounded">-->
        <!--      <a class="collapse-item <?php if(Request::segment(1) == "login_img_settings") echo "active"; ?>" href="{{url('/login_img_settings')}}">Login Image Settings</a>-->
        <!--    </div>-->
        <!--  </div>-->

        

        <li><a class="app-menu__item" href="{{url('logout')}}"><i class="app-menu__icon fa fa-sign-out"></i><span class="app-menu__label">Logout</span></a></li>

		

		<!--<li><a class="app-menu__item <?php // if(Request::segment(2) == "settings") echo "active"; ?>" href="{{url('admin/settings')}}"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Settings</span></a></li>

		

       

        <!--<li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Tables</span><i class="treeview-indicator fa fa-angle-right"></i></a>

          <ul class="treeview-menu">

            <li><a class="treeview-item" href="table-basic.html"><i class="icon fa fa-circle-o"></i> Basic Tables</a></li>

            <li><a class="treeview-item" href="table-data-table.html"><i class="icon fa fa-circle-o"></i> Data Tables</a></li>

          </ul>

        </li> -->

        

      </ul>

    </aside>
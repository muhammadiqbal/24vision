   <?php 
    $route= explode('@',Route::getCurrentRoute()->getActionName(),2)[0];
    ?>
   <!-- Sidebar Menu -->
    <ul class="sidebar-menu" data-widget="tree">
      
      <!-- Optionally, you can add icons to the links -->
      <li 
        @if( $route =='App\Http\Controllers\DashboardController')
          class="active"
        @endif
        >
        <a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
      </li>
      <li
        @if( $route =='App\Http\Controllers\ShipController')
          class="active"
        @endif
        >
        <a href="{{ url('/ships') }}"><i class="fa fa-ship"></i> <span>Ships</span></a></li>
      <li
        @if( $route =='App\Http\Controllers\CargoController')
          class="active"
        @endif
        >
        <a href="{{ url('/cargos') }}"><i class="fa fa-cubes"></i> <span>Cargo offers</span></a></li>
      <li  
        @if( $route =='App\Http\Controllers\EmailController')
          {{'class = "active"'}}
        @else
          {{'class= "treeview"'}}
        @endif
        "
        >
        <a href="{{url('/emails')}}"><i class="fa fa-envelope"></i> <span>Cargo Mail</span></a>
          <ul class="treeview-menu">
            <li>
              <a href="{{url('/emails')."?type=Cargo"}}"><i class="fa fa-cubes "></i>Extracted mails</a>
            </li>
            <li>
              <a href="{{url('/emails')."?type=Ship"}}"><i class="fa fa-ship"></i>Ship offer mail</a>
            </li>
            <li>
              <a href="{{url('/emails')."?type=Order"}}"> <i class="fa fa-ship"></i>Ship order mail</a>
            </li>
            <li>
              <a href="{{url('/emails')}}"> <i class="fa fa-star"></i>All mails</a>
            </li>
          </ul>
      </li>
      <li
        @if( $route =='App\Http\Controllers\FuelPriceController')
          class="active"
        @endif
        >
        <a href="{{url('/fuelPrices')}}"><i class="fa fa-tint"></i> <span>Fuel Price</span></a></li>
      <li
        @if( $route =='App\Http\Controllers\RouteController')
          class="active"
        @endif
        >
        <a href="{{url('/routes')}}"><i class="fa fa-compass"></i> <span>Route</span></a></li>
      <li
        @if( $route =='App\Http\Controllers\BdiController')
          class="active"
        @endif
        >
        <a href="{{url('/bdis')}}"><i class="fa fa-area-chart"></i> <span>Bdi</span></a></li>
        </li>
      <li
         @if( $route =='App\Http\Controllers\PortController')
          class="active"
        @endif>
        <a href="{{url('/ports')}}"><i class="fa fa-support"></i> <span>Ports</span></a></li>
      </li>
      <li
         @if( $route =='App\Http\Controllers\ZoneController')
          class="active"
        @endif>
        <a href="{{url('/zones')}}"><i class="fa fa-map"></i> <span>Zone</span></a></li>
      </li>
      <li
         @if( $route =='App\Http\Controllers\UserController')
          class="active"
        @endif>
        <a href="{{url('/users')}}"><i class="fa fa-user"></i> <span>Users</span></a></li>
      </li>
      {{-- <li
        @if( $route =='App\Http\Controllers\AgreementController')
          class="active"
        @endif
        ><a href="{{url('/agreements')}}"><i class="fa fa-link"></i> <span>Agreements</span></a></li>
       --}}
    </ul>
    <!-- /.sidebar-menu -->
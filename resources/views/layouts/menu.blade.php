   <?php 
    $route= explode('@',Route::getCurrentRoute()->getActionName(),2)[0];
    ?>
   <!-- Sidebar Menu -->
    <ul class="sidebar-menu" data-widget="tree">
      
      <!-- Optionally, you can add icons to the links -->
      <li 
        @if( $route =='App\Http\Controllers\HomeController')
          class="active"
        @endif
        >
        <a href="{{ url('/home') }}"><i class="fa fa-link"></i> <span>Dashboard</span></a>
      </li>
      <li
        @if( $route =='App\Http\Controllers\ShipController')
          class="active"
        @endif
        >
        <a href="{{ url('/ships') }}"><i class="fa fa-link"></i> <span>Ships</span></a></li>
      <li
        @if( $route =='App\Http\Controllers\CargoController')
          class="active"
        @endif
        >
        <a href="{{ url('/cargos') }}"><i class="fa fa-link"></i> <span>Cargo offers</span></a></li>
      <li
        @if( $route =='App\Http\Controllers\ShipPositionController')
          class="active"
        @endif
        >
        <a href="{{url('/shipPositions')}}"><i class="fa fa-link"></i> <span>Cargo Mail</span></a></li>
      <li
        @if( $route =='App\Http\Controllers\FuelPriceController')
          class="active"
        @endif
        >
        <a href="{{url('/fuelPrices')}}"><i class="fa fa-link"></i> <span>Fuel Price</span></a></li>
      <li
        @if( $route =='App\Http\Controllers\RouteController')
          class="active"
        @endif
        >
        <a href="{{url('/routes')}}"><i class="fa fa-link"></i> <span>Route</span></a></li>
      <li
        @if( $route =='App\Http\Controllers\BdiController')
          class="active"
        @endif
        >
        <a href="{{url('/bdis')}}"><i class="fa fa-link"></i> <span>Bdi</span></a></li>
      {{-- <li
        @if( $route =='App\Http\Controllers\AgreementController')
          class="active"
        @endif
        ><a href="{{url('/agreements')}}"><i class="fa fa-link"></i> <span>Agreements</span></a></li>
       --}}
    </ul>
    <!-- /.sidebar-menu -->
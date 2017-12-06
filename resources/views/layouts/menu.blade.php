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
        <a href="{{url('/shipPositions')}}"><i class="fa fa-link"></i> <span>Ship Positions</span></a></li>
      {{-- <li
        @if( $route =='App\Http\Controllers\AgreementController')
          class="active"
        @endif
        ><a href="{{url('/agreements')}}"><i class="fa fa-link"></i> <span>Agreements</span></a></li>
       --}}
    </ul>
    <!-- /.sidebar-menu -->
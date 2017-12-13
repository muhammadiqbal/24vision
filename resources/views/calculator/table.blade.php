<?php
    setlocale(LC_MONETARY, 'en_US');
    ?>
<table class="table table-responsive" id="ports-table">
    <thead>
        <th>Customer</th>
        <th>Remaining Size</th>
        {{-- <th>Remaining Draft</th> --}}
        <th>Start</th>
        <th>Destination</th>
        <th>Days to start</th>
        <th>Days to end</th>
        <th>Route</th>
        <th>NTC</th>
        <th>Gross rate</th>
        <th>NTCE</th>
    </thead>
    <tbody>
    @foreach( $cargos as $cargo)
        <tr>
            <td>{{$cargo->customer->name}}</td>
            <td>{{($ship->max_holds_capacity - 0) - ($cargo->quantity*$cargo->stowage_factor)}}</td>
            {{-- <td>{{}}</td> --}}
            <td>{{$cargo->loadingPort->name}}</td>
            <td>{{$cargo->dischargingPort->name}}</td>
            <td>{{\Carbon\Carbon::parse($cargo->laycan_first_day)->format('d-m-Y')}}</td>
            <td>{{\Carbon\Carbon::parse($cargo->laycan_last_day)->format('d-m-Y')}}</td>
            <td>{{$cargo->getRoute()->code}}</td>
            <td><b>USD</b>{{money_format(' %.2n', $cargo->getNtc())}}</td>
            <td><b>USD</b>{{money_format(' %.2n', $cargo->getGrossRate())}}</td>
            <td><b>USD</b>{{money_format(' %.2n', $cargo->getNtce())}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
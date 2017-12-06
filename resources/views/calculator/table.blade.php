<table class="table table-responsive" id="ports-table">
    <thead>
        <th>Customer</th>
        <th>Remaining Size</th>
        <th>Remaining Draft</th>
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
            <td></td>
            <td></td>
            <td>{{$cargo->loadingPort->name}}</td>
            <td>{{$cargo->dischargingPort->name}}</td>
            <td>{{Carbon\Carbon::parse($cargo->laycan_first_day)->diffInDays(Carbon\Carbon::now())}}</td>
            <td>{{Carbon\Carbon::parse($cargo->laycan_last_day)->diffInDays(Carbon\Carbon::now())}}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>
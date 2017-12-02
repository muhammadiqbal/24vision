<table class="table table-responsive" id="cargos-table">
    <thead>
        <th>Loading Port</th>
        <th>Discharging Port</th>
        <th>Laycan First Day</th>
        <th>Laycan Last Day</th>
        <th>Cargo Description</th>
        <th>Stowage Factor</th>
        <th>Ship Specialization</th>
        <th>Quantity</th>
        <th>Loading Rate</th>
        <th>Discharging Rate</th>
        <th>Freight Idea</th>
        <th>Extra Condition</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($cargos as $cargo)
        <tr>
            <td>{!! $cargo->loading_port !!}</td>
            <td>{!! $cargo->discharging_port !!}</td>
            <td>{!! $cargo->laycan_first_day !!}</td>
            <td>{!! $cargo->laycan_last_day !!}</td>
            <td>{!! $cargo->cargo_description !!}</td>
            <td>{!! $cargo->stowage_factor !!}.' '.{!! $cargo->stowageFactorUnit !!}</td>
            <td>{!! $cargo->shipSpecialization->name!!}</td>
            <td>{!! $cargo->quantity !!}{!! $cargo->quantity_measurement !!}</td>
            <td><b>{!! $cargo->loading_rate_type !!}</b>{!! $cargo->loading_rate !!}</td>
            <td><b>{!! $cargo->discharging_rate_type !!}</b>{!! $cargo->discharging_rate !!}</td>
            <td>{!! $cargo->freight_idea !!}{!! $cargo->freightIdeaMeasurement->name !!}</td>
            <td>{!! $cargo->extra_condition !!}</td>
            <td>
                {!! Form::open(['route' => ['cargos.destroy', $cargo->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('cargos.show', [$cargo->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('cargos.edit', [$cargo->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
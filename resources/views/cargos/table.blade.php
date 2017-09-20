<table class="table table-responsive" id="cargos-table">
    <thead>
        <th>Loading Port</th>
        <th>Discharging Port</th>
        <th>Laycan First Day</th>
        <th>Laycan Last Day</th>
        <th>Cargo Description</th>
        <th>Stowage Factor</th>
        <th>Sf Unit</th>
        <th>Ship Specialization Id</th>
        <th>Quantity Measurement Id</th>
        <th>Quantity</th>
        <th>Loading Rate Type</th>
        <th>Loading Rate</th>
        <th>Discharging Rate Type</th>
        <th>Discharging Rate</th>
        <th>Freight Idea Measurement Id</th>
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
            <td>{!! $cargo->stowage_factor !!}</td>
            <td>{!! $cargo->sf_unit !!}</td>
            <td>{!! $cargo->ship_specialization_id !!}</td>
            <td>{!! $cargo->quantity_measurement_id !!}</td>
            <td>{!! $cargo->quantity !!}</td>
            <td>{!! $cargo->loading_rate_type !!}</td>
            <td>{!! $cargo->loading_rate !!}</td>
            <td>{!! $cargo->discharging_rate_type !!}</td>
            <td>{!! $cargo->discharging_rate !!}</td>
            <td>{!! $cargo->freight_idea_measurement_id !!}</td>
            <td>{!! $cargo->freight_idea !!}</td>
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
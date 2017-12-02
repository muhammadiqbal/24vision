<table class="table table-responsive" id="shipPositions-table">
    <thead>
        <th>Ship Id</th>
        <th>Region Id</th>
        <th>Port Id</th>
        <th>Date Of Opening</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($shipPositions as $shipPosition)
        <tr>
            <td>{!! $shipPosition->ship->name !!}</td>
            <td>{!! $shipPosition->region->name !!}</td>
            <td>{!! $shipPosition->port->name !!}</td>
            <td>{!! $shipPosition->date_of_opening !!}</td>
            <td>
                {!! Form::open(['route' => ['shipPositions.destroy', $shipPosition->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('shipPositions.show', [$shipPosition->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('shipPositions.edit', [$shipPosition->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
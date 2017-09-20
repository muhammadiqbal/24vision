<table class="table table-responsive" id="ports-table">
    <thead>
        <th>Name</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($ports as $port)
        <tr>
            <td>{!! $port->name !!}</td>
            <td>
                {!! Form::open(['route' => ['ports.destroy', $port->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('ports.show', [$port->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('ports.edit', [$port->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
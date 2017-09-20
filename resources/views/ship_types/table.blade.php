<table class="table table-responsive" id="shipTypes-table">
    <thead>
        <th>Name</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($shipTypes as $shipType)
        <tr>
            <td>{!! $shipType->name !!}</td>
            <td>
                {!! Form::open(['route' => ['shipTypes.destroy', $shipType->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('shipTypes.show', [$shipType->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('shipTypes.edit', [$shipType->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
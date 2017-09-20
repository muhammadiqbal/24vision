<table class="table table-responsive" id="stowageFactorUnits-table">
    <thead>
        <th>Unit</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($stowageFactorUnits as $stowageFactorUnit)
        <tr>
            <td>{!! $stowageFactorUnit->unit !!}</td>
            <td>
                {!! Form::open(['route' => ['stowageFactorUnits.destroy', $stowageFactorUnit->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('stowageFactorUnits.show', [$stowageFactorUnit->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('stowageFactorUnits.edit', [$stowageFactorUnit->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
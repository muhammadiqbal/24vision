<table class="table table-responsive" id="ldRateTypes-table">
    <thead>
        <th>Name</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($ldRateTypes as $ldRateType)
        <tr>
            <td>{!! $ldRateType->name !!}</td>
            <td>
                {!! Form::open(['route' => ['ldRateTypes.destroy', $ldRateType->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('ldRateTypes.show', [$ldRateType->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('ldRateTypes.edit', [$ldRateType->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
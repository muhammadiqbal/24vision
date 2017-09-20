<table class="table table-responsive" id="shipSpecializations-table">
    <thead>
        <th>Name</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($shipSpecializations as $shipSpecialization)
        <tr>
            <td>{!! $shipSpecialization->name !!}</td>
            <td>
                {!! Form::open(['route' => ['shipSpecializations.destroy', $shipSpecialization->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('shipSpecializations.show', [$shipSpecialization->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('shipSpecializations.edit', [$shipSpecialization->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
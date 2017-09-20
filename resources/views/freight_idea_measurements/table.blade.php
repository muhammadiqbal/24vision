<table class="table table-responsive" id="freightIdeaMeasurements-table">
    <thead>
        <th>Name</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($freightIdeaMeasurements as $freightIdeaMeasurement)
        <tr>
            <td>{!! $freightIdeaMeasurement->name !!}</td>
            <td>
                {!! Form::open(['route' => ['freightIdeaMeasurements.destroy', $freightIdeaMeasurement->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('freightIdeaMeasurements.show', [$freightIdeaMeasurement->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('freightIdeaMeasurements.edit', [$freightIdeaMeasurement->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
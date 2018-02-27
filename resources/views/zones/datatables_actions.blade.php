{!! Form::open(['route' => ['zones.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ url('/zonePonts/create'.'?id='.$id) }}" class='btn btn-default btn-xs' data-toggle="tooltip" title="Add Zone Points.">
        <i class="glyphicon glyphicon-map-marker"></i>
    </a>
    <a href="{{ route('zones.show', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-eye-open" data-toggle="tooltip" title="View"></i>
    </a>
    <a href="{{ route('zones.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-edit" data-toggle="tooltip" title="Edit"></i>
    </a>


    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Are you sure?')",
        'data-toggle'=>"tooltip",
        'title'=>"Delete"
    ]) !!}
</div>


{!! Form::close() !!}

{!! Form::open(['route' => ['emails.destroy', $emailID], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('emails.show', $emailID) }}" target="_blank" class='btn btn-default btn-xs' data-toggle="tooltip" title="View">
        <i class="glyphicon glyphicon-eye-open"></i>
    </a>
    <a href="{{ route('emails.edit', $emailID) }}" class='btn btn-default btn-xs' data-toggle="tooltip" title="Edit">
        <i class="glyphicon glyphicon-edit"></i>
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



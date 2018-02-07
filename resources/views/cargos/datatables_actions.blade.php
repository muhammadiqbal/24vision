{!! Form::open(['route' => ['cargos.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-list-alt"></i>
    </a>
    <a href="{{url('/emails/'.$cargo->email_id)}}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-envelope" data-toggle="modal" data-target="#modalMail"></i>
    </a>
    <a class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-search"></i>
    </a>
    <a class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-warning-sign"></i>
    </a>
    <a href="{{ route('cargos.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-edit"></i>
    </a>
    <a href="{{ route('cargos.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-share"></i>
    </a>
    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}


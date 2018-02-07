<div class='btn-group'>

    <a href="{{url('/voyage/'.$ship->id.'/'.$cargo->id.'/'.$port->id.'/'.$date_of_opening)}}" target="_blank" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-search"></i>
    </a>
    <a href="{{url('/emails/'.$cargo->email_id)}}"  target="_blank" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-envelope" data-toggle="modal" data-target="#modalMail"></i>
    </a>
    <a class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-warning-sign"></i>
    </a>
    <a href="{{ route('cargos.edit', $cargo->id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-share"></i>
    </a>
</div>


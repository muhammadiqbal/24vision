<div class='btn-group' style="display: inline-flex;">

    <a href="{{url('/voyage/'.$ship->id.'/'.$cargo->id.'/'.$port->id.'/'.$date_of_opening)}}" target="_blank" class='btn btn-default btn-xs' data-toggle="tooltip" title="View Voyage">
        <i class="glyphicon glyphicon-search"></i>
    </a>
    <a href="{{url('/emails/'.$cargo->email_id)}}"  target="_blank" class='btn btn-default btn-xs' data-toggle="tooltip" title="View Mail">
        <i class="glyphicon glyphicon-envelope"></i>
    </a>
    <a class='btn btn-default btn-xs' data-toggle="tooltip" title="forward to VMS">
        <i class="glyphicon glyphicon-share-alt"></i>
    </a>
    <a href="{{ route('cargos.edit', $cargo->id) }}" class='btn btn-default btn-xs' data-toggle="tooltip" title="Edit">
        <i class="glyphicon glyphicon-share"></i>
    </a>
</div>


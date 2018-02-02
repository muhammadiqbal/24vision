
<div class='btn-group'>
    <a class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-list-alt"></i>
    </a>
    <a href="{{url('/voyage/'.$id.'/'.$selectedShip)}}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-search"></i>
    </a>
    <a class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-envelope" data-toggle="modal" data-target="#modalMail"></i>
    </a>
    <a class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-warning-sign"></i>
    </a>
    <a href="{{ route('cargos.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-share"></i>
    </a>
</div>


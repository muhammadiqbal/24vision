<?php
    $selectedShip=$_GET['ship_id'];
    $date_of_opening=$_GET['port_id'];
    $ports=$_GET['date_of_opening'];
?>
<div class='btn-group'>
    <a class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-list-alt"></i>
    </a>
    <a href="{{url('/voyage/'.$selectedShip.'/'.$id.'/'.$ports.'/'.$date_of_opening)}}" class='btn btn-default btn-xs'>
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


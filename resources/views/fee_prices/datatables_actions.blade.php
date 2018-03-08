{!! Form::open(['route' => ['feePrices.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
     <a href="{!! url('/linechart?entity=feePrice&port='.$port_id) !!}" target="_blank" class='btn btn-default btn-xs' data-toggle="tooltip" title="trends">
        <i class="fa fa-area-chart"></i>
    </a>
    <a href="{{ route('feePrices.show', $id) }}" target="_blank" class='btn btn-default btn-xs' ata-toggle="tooltip" title="View">
        <i class="glyphicon glyphicon-eye-open"></i>
    </a>
    <a href="{{ route('feePrices.edit', $id) }}" class='btn btn-default btn-xs' ata-toggle="tooltip" title="Edit">
        <i class="glyphicon glyphicon-edit"></i>
    </a>
    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Are you sure?')",
        'data-toggle'=>"tooltip",
        'title'=>"View"
    ]) !!}
</div>
{!! Form::close() !!}

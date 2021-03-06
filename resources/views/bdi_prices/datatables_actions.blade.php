{!! Form::open(['route' => ['bdiPrices.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{!! url('/linechart?entity=bdiPrice&bdi='.$bdi_id) !!}" target="_blank" class='btn btn-default btn-xs' data-toggle="tooltip" title="trends">
        <i class="fa fa-area-chart"></i>
    </a>
    <a href="{{ route('bdiPrices.show', $id) }}" class='btn btn-default btn-xs' data-toggle="tooltip" title="View">
        <i class="glyphicon glyphicon-eye-open"></i>
    </a>
    <a href="{{ route('bdiPrices.edit', $id) }}" class='btn btn-default btn-xs' data-toggle="tooltip" title="Edit">
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

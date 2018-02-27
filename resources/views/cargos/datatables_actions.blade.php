<div class='btn-group' style="display: inline-flex;">
    <a href="{{url('/emails/'.$email_id)}}"  target="_blank" class='btn btn-default btn-xs' data-toggle="tooltip" title="View mail">
        <i class="glyphicon glyphicon-envelope"></i>
    </a>

    {!! Form::open(['url'=>url('/emails/reclassify/'.$email_id), 'method' => 'put']) !!}
    {!! Form::button('<i class="glyphicon glyphicon-cog"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-xs',
        'onclick' => "return confirm('Reclassify this email?')",
        'data-toggle'=>"tooltip", 
        'title'=>"reclassify"
    ]) !!}
    {!! Form::close() !!}
    
    {{-- mark mail as used fo training --}}
    {{-- <a class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-warning-sign"></i>
    </a> --}}

    <a href="{{ route('cargos.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-edit"></i>
    </a>

    {!! Form::open(['route' => ['cargos.destroy', $id], 'method' => 'delete']) !!}
    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Are you sure?')",
        'data-toggle'=>"tooltip", 
        'title'=>"Delete cargo offer entry"
    ]) !!}
    {!! Form::close() !!}
</div>



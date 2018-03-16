<!-- Port Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('port_id', 'Port Id:') !!}
    <select name="port_id" class="form-control">
    @foreach($ports as $port)
            @if(!empty($feePrice) && $feePrice->port_id == $port->id)
                <option value="{{$port->id}}" selected="true">{{$port->name}}</option>
            @else
                <option value="{{$port->id}}">{{$port->name}}</option>
            @endif
    @endforeach
    </select>
</div>

<!-- Star Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_date', 'Start Date:') !!}
    @if($feePrice)
        {!! Form::date('start_date', $feePrice->start_date, ['class' => 'form-control']) !!}
    @else
        {!! Form::date('start_date', null, ['class' => 'form-control']) !!}
    @endif
</div>

<!-- End Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_date', 'End Date:') !!}
    @if($feePrice)
        {!! Form::date('end_date', $feePrice->end_date, ['class' => 'form-control']) !!}
    @else
        {!! Form::date('end_date', null, ['class' => 'form-control']) !!}
    @endif
</div>

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::number('price', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('feePrices.index') !!}" class="btn btn-default">Cancel</a>
</div>

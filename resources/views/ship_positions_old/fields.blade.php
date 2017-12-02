<!-- Ship Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ship_id', 'Ship:') !!}
   
    <select name="ship_id" class="form-control">
        @foreach($ships as $ship)
            <option value="{{$ship->id}}">{{$ship->name}}</option>
        @endforeach
    </select>
</div>

<!-- Region Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('region_id', 'Region:') !!}
    <select name="region_id" class="form-control">
        @foreach($regions as $region)
            <option value="{{$region->id}}">{{$region->name}}</option>
        @endforeach
    </select>
</div>

<!-- Port Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('port_id', 'Port :') !!}
    <select name="port_id" class="form-control">
        @foreach($ports as $port)
            <option value="{{$port->id}}">{{$port->name}}</option>
        @endforeach
    </select>
</div>

<!-- Date Of Opening Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date_of_opening', 'Date Of Opening:') !!}
    {!! Form::date('date_of_opening', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('shipPositions.index') !!}" class="btn btn-default">Cancel</a>
</div>

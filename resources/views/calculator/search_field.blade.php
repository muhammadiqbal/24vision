{!! Form::model($shipPosition, ['url' => ['/home'], 'method' => 'get']) !!}

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
    {!! Form::label('port_id', 'Port:') !!}
    <select name="port_id" class="form-control">
        @foreach($ports as $port)
            <option value="{{$port->id}}">{{$port->name}}</option>
        @endforeach
    </select>
</div>

<!-- Date Of Opening Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date_of_opening', 'Date Of Opening:') !!}
    {!! Form::date('date_of_opening',date($shipPosition->date_of_opening), ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('ship_specialization', 'Ship specialization:') !!}
    {{$shipPosition->ship->shipSpecialization->name}}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
</div>
{!! Form::close() !!}
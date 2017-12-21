{!! Form::model($shipPosition, ['url' => ['/home'], 'method' => 'get']) !!}

<!-- Ship Id Field -->
<div class="form-group col-sm-8">
    {!! Form::label('ship_id', 'Ship:') !!}
    <select name="ship_id" class="form-control">
        @foreach($ships as $ship)
            @if($ship->id == $shipPosition->ship->id)
                <option value="{{$ship->id}}" selected="true">{{$ship->name}}</option>
            @else
                <option value="{{$ship->id}}">{{$ship->name}}</option>
            @endif
        @endforeach
    </select>
</div>

<!-- Date Of Opening Field -->
<div class="form-group col-sm-4">
    {!! Form::label('occupied_size', 'Occupied size:') !!}
    {!! Form::number('occupied_size',null, ['class' => 'form-control']) !!}
</div>

{{-- <!-- Region Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('region_id', 'Region:') !!}
        <select name="region_id" class="form-control">
        @foreach($regions as $region)
            @if($region->id == $shipPosition->region_id)
                <option value="{{$region->id}}" selected="true">{{$region->name}}</option>
            @else
                <option value="{{$region->id}}">{{$region->name}}</option>
            @endif
        @endforeach
    </select>
</div> --}}

<!-- Port Id Field -->
<div class="form-group col-sm-8">
    {!! Form::label('port_id', 'Port:') !!}
    <select name="port_id" class="form-control">
        @foreach($ports as $port)
            @if($port->id == $shipPosition->port_id )
                <option value="{{$port->id}}" selected="true">{{$port->name}}</option>
            @else
                <option value="{{$port->id}}">{{$port->name}}</option>
            @endif
        @endforeach
    </select>
</div>

<!-- Date Of Opening Field -->
<div class="form-group col-sm-4">
    {!! Form::label('occupied_tonage', 'Occupied tonage:') !!}
    {!! Form::number('occupied_tonage',null, ['class' => 'form-control']) !!}
</div>


<!-- Date Of Opening Field -->
<div class="form-group col-sm-4">
    {!! Form::label('date_of_opening', 'Date Of Opening:') !!}
    {!! Form::date('date_of_opening',date($shipPosition->date_of_opening), ['class' => 'form-control']) !!}
</div>


<!-- Date Of Opening Field -->
<div class="form-group col-sm-4">
    {!! Form::label('Range', 'Range:') !!}
    {!! Form::number('range',null, ['class' => 'form-control']) !!}
</div>

<!-- Date Of Opening Field -->
<div class="form-group col-sm-4">
    {!! Form::label('current_draft', 'Current draft:') !!}
    {!! Form::number('current_draft',null, ['class' => 'form-control']) !!}
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
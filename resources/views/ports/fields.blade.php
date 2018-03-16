<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Zone Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('zone_id', 'Zone Id:') !!}
    {!! Form::number('zone_id', null, ['class' => 'form-control']) !!}
    <select name="zone_id" class="form-control">
        @foreach($zones as $zone)
            @if($port && $port->id == $zone->id)
                <option value="{{$zone->id}}" selected="true">{{$zone->name}}</option>
            @else
                <option value="{{$zone->id}}">{{$zone->name}}</option>
            @endif
        @endforeach
    </select>
</div>

<!-- Max Laden Draft Field -->
<div class="form-group col-sm-6">
    {!! Form::label('max_laden_draft', 'Max Laden Draft:') !!}
    {!! Form::number('max_laden_draft', null, ['class' => 'form-control']) !!}
</div>

<!-- Latitude Field -->
<div class="form-group col-sm-6">
    {!! Form::label('latitude', 'Latitude:') !!}
    {!! Form::number('latitude', null, ['class' => 'form-control']) !!}
</div>

<!-- Longitude Field -->
<div class="form-group col-sm-6">
    {!! Form::label('longitude', 'Longitude:') !!}
    {!! Form::number('longitude', null, ['class' => 'form-control']) !!}
</div>

<!-- Draft Factor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('draft_factor', 'Draft Factor:') !!}
    {!! Form::number('draft_factor', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('ports.index') !!}" class="btn btn-default">Cancel</a>
</div>

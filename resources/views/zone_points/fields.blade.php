<!-- Zone Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('zone_id', 'Zone :') !!}
    <select name="zone_id" ="" class="form-control" 
    @if ($_GET['id']) {{'read-only="true"'}} @endif>
        @foreach($zones as $zone)
            @if(!empty($zone_point) && $zone_point->zone_id == $zone->id)
                <option value="{{$zone->id}}" selected="true">{{$zone->name}}</option>
            @elseif($_GET['id'] == $zone->id)
                <option value="{{$zone->id}}" selected="true">{{$zone->name}}</option>
            @else
                <option value="{{$zone->id}}">{{$zone->name}}</option>
            @endif
        @endforeach
    </select>
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

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('zonePoints.index') !!}" class="btn btn-default">Cancel</a>
</div>

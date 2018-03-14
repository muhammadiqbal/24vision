<!-- Route Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('route_id', 'Route Id:') !!}
    {!! Form::number('route_id', null, ['class' => 'form-control']) !!}
    <select name="route_id" class="form-control">
     @foreach($routes as $route)
            @if(!empty($path) && $path->route_id == $route->id)
                <option value="{{$route->id}}" selected="true">{{$route->name}}</option> 
            @else
                <option value="{{$route->id}}">{{$route->name}}</option>
            @endif
    @endforeach
    </select>
</div>

<!-- Zone1 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('zone1', 'Zone1:') !!}
    <select name="zone1" class="form-control">
     @foreach($zones as $zone)
            @if(!empty($path) && $path->zone1 == $zone->id)
                <option value="{{$zone->id}}" selected="true">{{$zone->name}}</option>
            @else
                <option value="{{$zone->id}}">{{$zone->name}}</option>
            @endif
    @endforeach
    </select>
</div>

<!-- Zone2 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('zone2', 'Zone2:') !!}
    <select name="zone2" class="form-control">
    @foreach($zones as $zone)
            @if(!empty($path) && $path->zone2 == $zone->id)
                <option value="{{$zone->id}}" selected="true">{{$zone->name}}</option>
            @else
                <option value="{{$zone->id}}">{{$zone->name}}</option>
            @endif
    @endforeach
    </select>
</div>

<!-- Zone3 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('zone3', 'Zone3:') !!}
    <select name="zone3" class="form-control">
    @foreach($zones as $zone)
            @if(!empty($path) && $path->zone3 == $zone->id)
                <option value="{{$zone->id}}" selected="true">{{$zone->name}}</option>
            @else
                <option value="{{$zone->id}}">{{$zone->name}}</option>
            @endif
    @endforeach
    </select>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('paths.index') !!}" class="btn btn-default">Cancel</a>
</div>

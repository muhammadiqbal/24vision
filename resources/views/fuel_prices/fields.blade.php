<!-- Fuel Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fuel_type_id', 'Fuel Type:') !!}
    <select name="fuel_type_id" class="form-control">
        @foreach($fuelTypes as $fuelType)
                @if(!empty($fuelPrice) && $fuelType->id == $fuelPrice->fuel_type_id )
                    <option value="{{$fuelType->id}}" selected="true">{{$fuelType->name}}</option>
                @else
                    <option value="{{$fuelType->id}}">{{$fuelType->name}}</option>
                @endif
        @endforeach
    </select>
</div>



<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::number('price', null, ['class' => 'form-control']) !!}
</div>

<!-- Start Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_date', 'Start Date:') !!}
    {!! Form::date('start_date', null, ['class' => 'form-control']) !!}
</div>

<!-- End Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_date', 'End Date:') !!}
    {!! Form::date('end_date', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('fuelPrices.index') !!}" class="btn btn-default">Cancel</a>
</div>

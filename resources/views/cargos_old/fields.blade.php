<!-- Loading Port Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loading_port', 'Loading Port:') !!}
     <select name="loading_port" class="form-control">
        @foreach($ports as $port)
            <option value="{{$port->id}}">{{$port->name}}</option>
        @endforeach
    </select>
</div>

<!-- Discharging Port Field -->
<div class="form-group col-sm-6">
    {!! Form::label('discharging_port', 'Discharging Port:') !!}
    <select name="discharging_port" class="form-control">
        @foreach($ports as $port)
            <option value="{{$port->id}}">{{$port->name}}</option>
        @endforeach
    </select>
</div>

<!-- Laycan First Day Field -->
<div class="form-group col-sm-6">
    {!! Form::label('laycan_first_day', 'Laycan First Day:') !!}
    {!! Form::date('laycan_first_day', null, ['class' => 'form-control']) !!}
</div>

<!-- Laycan Last Day Field -->
<div class="form-group col-sm-6">
    {!! Form::label('laycan_last_day', 'Laycan Last Day:') !!}
    {!! Form::date('laycan_last_day', null, ['class' => 'form-control']) !!}
</div>

<!-- Cargo Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cargo_description', 'Cargo Description:') !!}
    {!! Form::text('cargo_description', null, ['class' => 'form-control']) !!}
</div>

<!-- Stowage Factor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('stowage_factor', 'Stowage Factor:') !!}
    {!! Form::number('stowage_factor', null, ['class' => 'form-control']) !!}
    <select name="sf_unit" class="form-control">
        @foreach($sfUnits as $sfUnit)
            <option value="{{$sfUnit->id}}">{{$sfUnit->unit}}</option>
        @endforeach
    </select>
</div>

{{-- <!-- Sf Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sf_unit', 'Sf Unit:') !!}
    {!! Form::number('sf_unit', null, ['class' => 'form-control']) !!}
</div> --}}

<!-- Ship Specialization Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ship_specialization_id', 'Ship Specialization Id:') !!}
    <select name="ship_specialization_id" class="form-control">
        @foreach($shipSpecializations as $shipSpecialization)
            <option value="{{$shipSpecialization->id}}">{{$shipSpecialization->name}}</option>
        @endforeach
    </select>
</div>



<!-- Quantity Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity', 'Quantity:') !!}
    <select name="quantity_measurement_id" class="form-control">
        @foreach($quantityMeasurements as $quantityMeasurement)
            <option value="{{$quantityMeasurement->id}}">{{$quantityMeasurement->name}}</option>
        @endforeach
    </select>
    {!! Form::number('quantity', null, ['class' => 'form-control']) !!}
    
</div>

{{-- <!-- Loading Rate Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loading_rate_type', 'Loading Rate Type:') !!}
    {!! Form::number('loading_rate_type', null, ['class' => 'form-control']) !!}
</div> --}}

<!-- Loading Rate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loading_rate', 'Loading Rate:') !!}
    {!! Form::number('loading_rate', null, ['class' => 'form-control']) !!}
    <select name="loading_rate_type" class="form-control">
        @foreach($ldRateTypes as $ldRateType)
            <option value="{{$ldRateType->id}}">{{$ldRateType->name}}</option>
        @endforeach
    </select>
</div>

{{-- <!-- Discharging Rate Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('discharging_rate_type', 'Discharging Rate Type:') !!}
    {!! Form::number('discharging_rate_type', null, ['class' => 'form-control']) !!}
</div>
 --}}

<!-- Discharging Rate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('discharging_rate', 'Discharging Rate:') !!}
    {!! Form::number('discharging_rate', null, ['class' => 'form-control']) !!}
    <select name="discharging_rate_type" class="form-control">
        @foreach($ldRateTypes as $ldRateType)
            <option value="{{$ldRateType->id}}">{{$ldRateType->name}}</option>
        @endforeach
    </select>
</div>

{{-- <!-- Freight Idea Measurement Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('freight_idea_measurement_id', 'Freight Idea Measurement Id:') !!}
    {!! Form::number('freight_idea_measurement_id', null, ['class' => 'form-control']) !!}
</div> --}}

<!-- Freight Idea Field -->
<div class="form-group col-sm-6">
    {!! Form::label('freight_idea', 'Freight Idea:') !!}
    {!! Form::number('freight_idea', null, ['class' => 'form-control']) !!}
    <select name="freight_idea_measurement_id" class="form-control">
        @foreach($freightIdeaMeasurements as $freightIdeaMeasurement)
            <option value="{{$freightIdeaMeasurement->id}}">{{$freightIdeaMeasurement->name}}</option>
        @endforeach
    </select>
</div>

<!-- Extra Condition Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('extra_condition', 'Extra Condition:') !!}
    {!! Form::textarea('extra_condition', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('cargos.index') !!}" class="btn btn-default">Cancel</a>
</div>

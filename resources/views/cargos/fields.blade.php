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

<!-- Cargo Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cargo_type_id', 'Cargo Type Id:') !!}
    {!! Form::number('cargo_type_id', null, ['class' => 'form-control']) !!}
    <select name="cargo_type_id" class="form-control">
        @foreach($cargo_types as $cargo_type)
            <option value="{{$cargo_type->id}}">{{$cargo_type->name}}</option>
        @endforeach
    </select>
</div>

<!-- Stowage Factor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('stowage_factor', 'Stowage Factor:') !!}
    {!! Form::number('stowage_factor', null, ['class' => 'form-control']) !!}
</div>

<!-- Sf Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sf_unit', 'Sf Unit:') !!}
    <select name="sf_unit" class="form-control">
        @foreach($sf_units as $sf_unit)
            <option value="{{$sf_unit->id}}">{{$sf_unit->name}}</option>
        @endforeach
    </select>
</div>

<!-- Ship Specialization Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ship_specialization_id', 'Ship Specialization Id:') !!}
    <select name="ship_specialization_id" class="form-control">
        @foreach($ship_specializations as $ship_specialization)
            <option value="{{$ship_specialization->id}}">{{$ship_specialization->name}}</option>
        @endforeach
    </select>
</div>

<!-- Quantity Measurement Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity_measurement_id', 'Quantity Measurement Id:') !!}
    <select name="quantity_measurement_id" class="form-control">
        @foreach($quantity_measurements as $quantity_measurement)
            <option value="{{$quantity_measurement->id}}">{{$quantity_measurement->name}}</option>
        @endforeach
    </select>
</div>

<!-- Quantity Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity', 'Quantity:') !!}
    {!! Form::number('quantity', null, ['class' => 'form-control']) !!}
</div>

<!-- Loading Rate Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loading_rate_type', 'Loading Rate Type:') !!}
    <select name="loading_rate_type" class="form-control">
        @foreach($ld_rate_types as $ld_rate_type)
            <option value="{{$ld_rate_type->id}}">{{$ld_rate_type->name}}</option>
        @endforeach
    </select>
</div>


<!-- Loading Rate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loading_rate', 'Loading Rate:') !!}
    {!! Form::number('loading_rate', null, ['class' => 'form-control']) !!}
</div>

<!-- Discharging Rate Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('discharging_rate_type', 'Discharging Rate Type:') !!}
    {!! Form::number('discharging_rate_type', null, ['class' => 'form-control']) !!}
    <select name="discharging_rate_type" class="form-control">
        @foreach($ld_rate_types as $ld_rate_type)
            <option value="{{$ld_rate_type->id}}">{{$ld_rate_type->name}}</option>
        @endforeach
    </select>
</div>


<!-- Discharging Rate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('discharging_rate', 'Discharging Rate:') !!}
    {!! Form::number('discharging_rate', null, ['class' => 'form-control']) !!}
</div>

<!-- Extra Condition Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('extra_condition', 'Extra Condition:') !!}
    {!! Form::textarea('extra_condition', null, ['class' => 'form-control']) !!}
</div>

<!-- Comission Field -->
<div class="form-group col-sm-6">
    {!! Form::label('commission', 'Comission:') !!}
    {!! Form::number('commission', null, ['class' => 'form-control']) !!}
</div>

<!-- Emailid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email_id', 'Emailid:') !!}
    {!! Form::number('email_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status_id', 'Status Id:') !!}
    <select name="status_id" class="form-control">
        @foreach($cargo_statuses as $cargo_status)
            <option value="{{$cargo_status->id}}">{{$cargo_status->name}}</option>
        @endforeach
    </select>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('cargos.index') !!}" class="btn btn-default">Cancel</a>
</div>

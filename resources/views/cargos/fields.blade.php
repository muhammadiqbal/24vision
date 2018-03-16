<!-- Loading Port Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loading_port', 'Loading Port:') !!}
    <select name="loading_port" class="form-control">
            <option value=""></option>
        @foreach($ports as $port)
            @if(!empty($cargo) && $cargo->loading_port == $port->id)
                <option value="{{$port->id}}" selected="true">{{$port->name}}</option>
            @else
                <option value="{{$port->id}}">{{$port->name}}</option>
            @endif
        @endforeach
    </select>
</div>

<!-- Discharging Port Field -->
<div class="form-group col-sm-6">
    {!! Form::label('discharging_port', 'Discharging Port:') !!}
    <select name="discharging_port" class="form-control">
        <option value=""></option>
        @foreach($ports as $port)
            @if(!empty($cargo) && $cargo->discharging_port == $port->id)
                <option value="{{$port->id}}" selected="true">{{$port->name}}</option>
            @else
                <option value="{{$port->id}}">{{$port->name}}</option>
            @endif
        @endforeach
    </select>
</div>

<!-- Laycan First Day Field -->
<div class="form-group col-sm-6">
    {!! Form::label('laycan_first_day', 'Laycan First Day:') !!}
    @if($cargo)
        {!! Form::date('laycan_first_day', $cargo->laycan_first_day, ['class' => 'form-control']) !!}
    @else
        {!! Form::date('laycan_first_day', null, ['class' => 'form-control']) !!}
    @endif
</div>

<!-- Laycan Last Day Field -->
<div class="form-group col-sm-6">
    {!! Form::label('laycan_last_day', 'Laycan Last Day:') !!}
    @if($cargo)
        {!! Form::date('laycan_last_day', $cargo->laycan_last_day, ['class' => 'form-control']) !!}
    @else
        {!! Form::date('laycan_last_day', null, ['class' => 'form-control']) !!}
    @endif
</div>

<!-- Cargo Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cargo_type_id', 'Cargo Type Id:') !!}
    <select name="cargo_type_id" class="form-control">
        <option value=""></option>
        @foreach($cargo_types as $cargo_type)
            @if(!empty($cargo) && $cargo->cargo_type_id == $cargo_type->id)
                <option value="{{$cargo_type->id}}" selected="true">{{$cargo_type->name}}</option>
            @else
                <option value="{{$cargo_type->id}}">{{$cargo_type->name}}</option>
            @endif
        @endforeach
    </select>
</div>

<!-- Stowage Factor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('stowage_factor', 'Stowage Factor:') !!}
    {!! Form::number('stowage_factor', null, ['class' => 'form-control','step'=>'any', 'min'=>'0']) !!}
</div>

<!-- Sf Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sf_unit', 'Sf Unit:') !!}
    <select name="sf_unit" class="form-control">
        <option value=""></option>
        @foreach($sf_units as $sf_unit)
            @if(!empty($cargo) && $cargo->sf_unit == $sf_unit->id)
                <option value="{{$sf_unit->id}}" selected="true">{{$sf_unit->unit}}</option>
            @else
                <option value="{{$sf_unit->id}}">{{$sf_unit->unit}}</option>
            @endif
        @endforeach
    </select>
</div>

<!-- Ship Specialization Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ship_specialization_id', 'Ship Specialization Id:') !!}
    <select name="ship_specialization_id" class="form-control">
        <option value=""></option>
        @foreach($ship_specializations as $ship_specialization)
            @if(!empty($cargo) && $cargo->ship_specialization_id == $ship_specialization->id)
                <option value="{{$ship_specialization->id}}">{{$ship_specialization->name}}</option>
            @else
                <option value="{{$ship_specialization->id}}" selected="true">{{$ship_specialization->name}}</option>

            @endif
        @endforeach
    </select>
</div>

<!-- Quantity Measurement Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity_measurement_id', 'Quantity Measurement Id:') !!}
    <select name="quantity_measurement_id" class="form-control">
        <option value=""></option>
        @foreach($quantity_measurements as $quantity_measurement)
            @if(!empty($cargo) && $cargo->quantity_measurement_id == $quantity_measurement->id)
                <option value="{{$quantity_measurement->id}}" selected="true">{{$quantity_measurement->name}}</option>
            @else
                <option value="{{$quantity_measurement->id}}">{{$quantity_measurement->name}}</option>
            @endif
        @endforeach
    </select>
</div>

<!-- Quantity Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity', 'Quantity:') !!}
    {!! Form::number('quantity', null, ['class' => 'form-control','step'=>'any', 'min'=>'0']) !!}
</div>

<!-- Loading Rate Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loading_rate_type', 'Loading Rate Type:') !!}
    <select name="loading_rate_type" class="form-control">
        <option value=""></option>
        @foreach($ld_rate_types as $ld_rate_type)
            @if(!empty($cargo) && $cargo->loading_rate_type == $ld_rate_type->id)
                <option value="{{$ld_rate_type->id}}" selected="true">{{$ld_rate_type->name}}</option>
            @else
                <option value="{{$ld_rate_type->id}}">{{$ld_rate_type->name}}</option>
            @endif
        @endforeach
    </select>
</div>


<!-- Loading Rate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loading_rate', 'Loading Rate:') !!}
    {!! Form::number('loading_rate', null, ['class' => 'form-control','step'=>'any', 'min'=>'0']) !!}
</div>

<!-- Discharging Rate Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('discharging_rate_type', 'Discharging Rate Type:') !!}
    <select name="discharging_rate_type" class="form-control">
        <option value=""></option>
        @foreach($ld_rate_types as $ld_rate_type)
            @if(!empty($cargo) && $cargo->discharging_rate_type == $ld_rate_type->id)
                <option value="{{$ld_rate_type->id}}">{{$ld_rate_type->name}}</option>
            @else
                <option value="{{$ld_rate_type->id}}">{{$ld_rate_type->name}}</option>
            @endif
        @endforeach
    </select>
</div>


<!-- Discharging Rate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('discharging_rate', 'Discharging Rate:') !!}
    {!! Form::number('discharging_rate', null, ['class' => 'form-control','step'=>'any', 'min'=>'0']) !!}
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
    {!! Form::number('email_id', null, ['class' => 'form-control','step'=>'1', 'min'=>'1']) !!}
</div>

<!-- Status Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status_id', 'Status Id:') !!}
    <select name="status_id" class="form-control">
        <option value=""></option>
        @foreach($cargo_statuses as $cargo_status)
            @if(!empty($cargo) && $cargo->status_id == $cargo_status->id)
                <option value="{{$cargo_status->id}}" selected="true">{{$cargo_status->name}}</option>
            @else
                <option value="{{$cargo_status->id}}">{{$cargo_status->name}}</option>
            @endif
        @endforeach
    </select>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('cargos.index') !!}" class="btn btn-default">Cancel</a>
</div>

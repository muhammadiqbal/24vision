<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $cargo->id !!}</p>
</div>

<!-- Loading Port Field -->
<div class="form-group">
    {!! Form::label('loading_port', 'Loading Port:') !!}
    <p>{!! isset($cargo->loading_port) ? $cargo->loadingPort :null !!}</p>
</div>

<!-- Loading Port Manual Field -->
<div class="form-group">
    {!! Form::label('loading_port_manual', 'Loading Port Manual:') !!}
    <p>{!! $cargo->loading_port_manual !!}</p>
</div>

<!-- Discharging Port Field -->
<div class="form-group">
    {!! Form::label('discharging_port', 'Discharging Port:') !!}
    <p>{!! isset($cargo->discharging_rate) ? $cargo->dischargingPort->name :null !!}</p>
</div>

<!-- Discharging Port Manual Field -->
<div class="form-group">
    {!! Form::label('discharging_port_manual', 'Discharging Port Manual:') !!}
    <p>{!! $cargo->discharging_port_manual !!}</p>
</div>

<!-- Laycan First Day Field -->
<div class="form-group">
    {!! Form::label('laycan_first_day', 'Laycan First Day:') !!}
    <p>{!! $cargo->laycan_first_day !!}</p>
</div>

<!-- Laycan First Day Manual Field -->
<div class="form-group">
    {!! Form::label('laycan_first_day_manual', 'Laycan First Day Manual:') !!}
    <p>{!! $cargo->laycan_first_day_manual !!}</p>
</div>

<!-- Laycan Last Day Field -->
<div class="form-group">
    {!! Form::label('laycan_last_day', 'Laycan Last Day:') !!}
    <p>{!! $cargo->laycan_last_day !!}</p>
</div>

<!-- Laycan Last Day Manual Field -->
<div class="form-group">
    {!! Form::label('laycan_last_day_manual', 'Laycan Last Day Manual:') !!}
    <p>{!! $cargo->laycan_last_day_manual !!}</p>
</div>

<!-- Cargo Type Id Field -->
<div class="form-group">
    {!! Form::label('cargo_type_id', 'Cargo Type Id:') !!}
    <p>{!! $cargo->cargo_type_id !!}</p>
</div>

<!-- Cargo Type Id Manual Field -->
<div class="form-group">
    {!! Form::label('cargo_type_id_manual', 'Cargo Type Id Manual:') !!}
    <p>{!! $cargo->cargo_type_id_manual !!}</p>
</div>

<!-- Stowage Factor Field -->
<div class="form-group">
    {!! Form::label('stowage_factor', 'Stowage Factor:') !!}
    <p>{!! $cargo->stowage_factor !!}</p>
</div>

<!-- Stowage Factor Manual Field -->
<div class="form-group">
    {!! Form::label('stowage_factor_manual', 'Stowage Factor Manual:') !!}
    <p>{!! $cargo->stowage_factor_manual !!}</p>
</div>

<!-- Sf Unit Field -->
<div class="form-group">
    {!! Form::label('sf_unit', 'Sf Unit:') !!}
    <p></p>
</div>

<!-- Sf Unit Manual Field -->
<div class="form-group">
    {!! Form::label('sf_unit_manual', 'Sf Unit Manual:') !!}
    <p>{!! $cargo->sf_unit_manual !!}</p>
</div>

<!-- Ship Specialization Id Field -->
<div class="form-group">
    {!! Form::label('ship_specialization_id', 'Ship Specialization Id:') !!}
    <p>{!! isset($cargo->ship_specialization_id) ? $cargo->shipSpecialization->name : null !!}</p>
</div>

<!-- Ship Specialization Id Manual Field -->
<div class="form-group">
    {!! Form::label('ship_specialization_id_manual', 'Ship Specialization Id Manual:') !!}
    <p>{!! $cargo->ship_specialization_id_manual !!}</p>
</div>

<!-- Quantity Measurement Id Field -->
<div class="form-group">
    {!! Form::label('quantity_measurement_id', 'Quantity Measurement Id:') !!}
    <p>{!! $cargo->quantity_measurement_id !!}</p>
</div>

<!-- Quantity Measurement Id Manual Field -->
<div class="form-group">
    {!! Form::label('quantity_measurement_id_manual', 'Quantity Measurement Id Manual:') !!}
    <p>{!! $cargo->quantity_measurement_id_manual !!}</p>
</div>

<!-- Quantity Field -->
<div class="form-group">
    {!! Form::label('quantity', 'Quantity:') !!}
    <p>{!! $cargo->quantity !!}</p>
</div>

<!-- Quantity Manual Field -->
<div class="form-group">
    {!! Form::label('quantity_manual', 'Quantity Manual:') !!}
    <p>{!! $cargo->quantity_manual !!}</p>
</div>

<!-- Loading Rate Type Field -->
<div class="form-group">
    {!! Form::label('loading_rate_type', 'Loading Rate Type:') !!}
    <p>{!! $cargo->loading_rate_type !!}</p>
</div>

<!-- Loading Rate Type Manual Field -->
<div class="form-group">
    {!! Form::label('loading_rate_type_manual', 'Loading Rate Type Manual:') !!}
    <p>{!! $cargo->loading_rate_type_manual !!}</p>
</div>

<!-- Loading Rate Field -->
<div class="form-group">
    {!! Form::label('loading_rate', 'Loading Rate:') !!}
    <p>{!! $cargo->loading_rate !!}</p>
</div>

<!-- Loading Rate Manual Field -->
<div class="form-group">
    {!! Form::label('loading_rate_manual', 'Loading Rate Manual:') !!}
    <p>{!! $cargo->loading_rate_manual !!}</p>
</div>

<!-- Discharging Rate Type Field -->
<div class="form-group">
    {!! Form::label('discharging_rate_type', 'Discharging Rate Type:') !!}
    <p>{!! $cargo->discharging_rate_type !!}</p>
</div>

<!-- Discharging Rate Type Manual Field -->
<div class="form-group">
    {!! Form::label('discharging_rate_type_manual', 'Discharging Rate Type Manual:') !!}
    <p>{!! $cargo->discharging_rate_type_manual !!}</p>
</div>

<!-- Discharging Rate Field -->
<div class="form-group">
    {!! Form::label('discharging_rate', 'Discharging Rate:') !!}
    <p>{!! $cargo->discharging_rate !!}</p>
</div>

<!-- Discharging Rate Manual Field -->
<div class="form-group">
    {!! Form::label('discharging_rate_manual', 'Discharging Rate Manual:') !!}
    <p>{!! $cargo->discharging_rate_manual !!}</p>
</div>

<!-- Extra Condition Field -->
<div class="form-group">
    {!! Form::label('extra_condition', 'Extra Condition:') !!}
    <p>{!! $cargo->extra_condition !!}</p>
</div>

<!-- Extra Condition Manual Field -->
<div class="form-group">
    {!! Form::label('extra_condition_manual', 'Extra Condition Manual:') !!}
    <p>{!! $cargo->extra_condition_manual !!}</p>
</div>

<!-- Comission Field -->
<div class="form-group">
    {!! Form::label('comission', 'Comission:') !!}
    <p>{!! $cargo->comission !!}</p>
</div>

<!-- Commision Manual Field -->
<div class="form-group">
    {!! Form::label('commision_manual', 'Commision Manual:') !!}
    <p>{!! $cargo->commision_manual !!}</p>
</div>

<!-- Emailid Field -->
<div class="form-group">
    {!! Form::label('emailId', 'Emailid:') !!}
    <p><a href="{{url('emails/'.$cargo->emailId)}}">{!! $cargo->emailId !!}</a></p>
</div>

<!-- Emailid Manual Field -->
<div class="form-group">
    {!! Form::label('emailId_manual', 'Emailid Manual:') !!}
    <p>{!! $cargo->emailId_manual !!}</p>
</div>

<!-- Status Id Field -->
<div class="form-group">
    {!! Form::label('status_id', 'Status Id:') !!}
    <p>{!! $cargo->status_id !!}</p>
</div>

<!-- Status Id Manual Field -->
<div class="form-group">
    {!! Form::label('status_id_manual', 'Status Id Manual:') !!}
    <p>{!! $cargo->status_id_manual !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $cargo->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $cargo->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $cargo->deleted_at !!}</p>
</div>


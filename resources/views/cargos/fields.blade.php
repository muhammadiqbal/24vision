<!-- Loading Port Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loading_port', 'Loading Port:') !!}
    {!! Form::number('loading_port', null, ['class' => 'form-control']) !!}
</div>

<!-- Loading Port Manual Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loading_port_manual', 'Loading Port Manual:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('loading_port_manual', false) !!}
        {!! Form::checkbox('loading_port_manual', '1', null) !!} 1
    </label>
</div>

<!-- Discharging Port Field -->
<div class="form-group col-sm-6">
    {!! Form::label('discharging_port', 'Discharging Port:') !!}
    {!! Form::number('discharging_port', null, ['class' => 'form-control']) !!}
</div>

<!-- Discharging Port Manual Field -->
<div class="form-group col-sm-6">
    {!! Form::label('discharging_port_manual', 'Discharging Port Manual:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('discharging_port_manual', false) !!}
        {!! Form::checkbox('discharging_port_manual', '1', null) !!} 1
    </label>
</div>

<!-- Laycan First Day Field -->
<div class="form-group col-sm-6">
    {!! Form::label('laycan_first_day', 'Laycan First Day:') !!}
    {!! Form::date('laycan_first_day', null, ['class' => 'form-control']) !!}
</div>

<!-- Laycan First Day Manual Field -->
<div class="form-group col-sm-6">
    {!! Form::label('laycan_first_day_manual', 'Laycan First Day Manual:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('laycan_first_day_manual', false) !!}
        {!! Form::checkbox('laycan_first_day_manual', '1', null) !!} 1
    </label>
</div>

<!-- Laycan Last Day Field -->
<div class="form-group col-sm-6">
    {!! Form::label('laycan_last_day', 'Laycan Last Day:') !!}
    {!! Form::date('laycan_last_day', null, ['class' => 'form-control']) !!}
</div>

<!-- Laycan Last Day Manual Field -->
<div class="form-group col-sm-6">
    {!! Form::label('laycan_last_day_manual', 'Laycan Last Day Manual:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('laycan_last_day_manual', false) !!}
        {!! Form::checkbox('laycan_last_day_manual', '1', null) !!} 1
    </label>
</div>

<!-- Cargo Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cargo_type_id', 'Cargo Type Id:') !!}
    {!! Form::number('cargo_type_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Cargo Type Id Manual Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cargo_type_id_manual', 'Cargo Type Id Manual:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('cargo_type_id_manual', false) !!}
        {!! Form::checkbox('cargo_type_id_manual', '1', null) !!} 1
    </label>
</div>

<!-- Stowage Factor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('stowage_factor', 'Stowage Factor:') !!}
    {!! Form::number('stowage_factor', null, ['class' => 'form-control']) !!}
</div>

<!-- Stowage Factor Manual Field -->
<div class="form-group col-sm-6">
    {!! Form::label('stowage_factor_manual', 'Stowage Factor Manual:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('stowage_factor_manual', false) !!}
        {!! Form::checkbox('stowage_factor_manual', '1', null) !!} 1
    </label>
</div>

<!-- Sf Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sf_unit', 'Sf Unit:') !!}
    {!! Form::number('sf_unit', null, ['class' => 'form-control']) !!}
</div>

<!-- Sf Unit Manual Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sf_unit_manual', 'Sf Unit Manual:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('sf_unit_manual', false) !!}
        {!! Form::checkbox('sf_unit_manual', '1', null) !!} 1
    </label>
</div>

<!-- Ship Specialization Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ship_specialization_id', 'Ship Specialization Id:') !!}
    {!! Form::number('ship_specialization_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Ship Specialization Id Manual Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ship_specialization_id_manual', 'Ship Specialization Id Manual:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('ship_specialization_id_manual', false) !!}
        {!! Form::checkbox('ship_specialization_id_manual', '1', null) !!} 1
    </label>
</div>

<!-- Quantity Measurement Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity_measurement_id', 'Quantity Measurement Id:') !!}
    {!! Form::number('quantity_measurement_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Quantity Measurement Id Manual Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity_measurement_id_manual', 'Quantity Measurement Id Manual:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('quantity_measurement_id_manual', false) !!}
        {!! Form::checkbox('quantity_measurement_id_manual', '1', null) !!} 1
    </label>
</div>

<!-- Quantity Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity', 'Quantity:') !!}
    {!! Form::number('quantity', null, ['class' => 'form-control']) !!}
</div>

<!-- Quantity Manual Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity_manual', 'Quantity Manual:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('quantity_manual', false) !!}
        {!! Form::checkbox('quantity_manual', '1', null) !!} 1
    </label>
</div>

<!-- Loading Rate Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loading_rate_type', 'Loading Rate Type:') !!}
    {!! Form::number('loading_rate_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Loading Rate Type Manual Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loading_rate_type_manual', 'Loading Rate Type Manual:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('loading_rate_type_manual', false) !!}
        {!! Form::checkbox('loading_rate_type_manual', '1', null) !!} 1
    </label>
</div>

<!-- Loading Rate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loading_rate', 'Loading Rate:') !!}
    {!! Form::number('loading_rate', null, ['class' => 'form-control']) !!}
</div>

<!-- Loading Rate Manual Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loading_rate_manual', 'Loading Rate Manual:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('loading_rate_manual', false) !!}
        {!! Form::checkbox('loading_rate_manual', '1', null) !!} 1
    </label>
</div>

<!-- Discharging Rate Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('discharging_rate_type', 'Discharging Rate Type:') !!}
    {!! Form::number('discharging_rate_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Discharging Rate Type Manual Field -->
<div class="form-group col-sm-6">
    {!! Form::label('discharging_rate_type_manual', 'Discharging Rate Type Manual:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('discharging_rate_type_manual', false) !!}
        {!! Form::checkbox('discharging_rate_type_manual', '1', null) !!} 1
    </label>
</div>

<!-- Discharging Rate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('discharging_rate', 'Discharging Rate:') !!}
    {!! Form::number('discharging_rate', null, ['class' => 'form-control']) !!}
</div>

<!-- Discharging Rate Manual Field -->
<div class="form-group col-sm-6">
    {!! Form::label('discharging_rate_manual', 'Discharging Rate Manual:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('discharging_rate_manual', false) !!}
        {!! Form::checkbox('discharging_rate_manual', '1', null) !!} 1
    </label>
</div>

<!-- Extra Condition Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('extra_condition', 'Extra Condition:') !!}
    {!! Form::textarea('extra_condition', null, ['class' => 'form-control']) !!}
</div>

<!-- Extra Condition Manual Field -->
<div class="form-group col-sm-6">
    {!! Form::label('extra_condition_manual', 'Extra Condition Manual:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('extra_condition_manual', false) !!}
        {!! Form::checkbox('extra_condition_manual', '1', null) !!} 1
    </label>
</div>

<!-- Comission Field -->
<div class="form-group col-sm-6">
    {!! Form::label('comission', 'Comission:') !!}
    {!! Form::number('comission', null, ['class' => 'form-control']) !!}
</div>

<!-- Commision Manual Field -->
<div class="form-group col-sm-6">
    {!! Form::label('commision_manual', 'Commision Manual:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('commision_manual', false) !!}
        {!! Form::checkbox('commision_manual', '1', null) !!} 1
    </label>
</div>

<!-- Emailid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('emailId', 'Emailid:') !!}
    {!! Form::number('emailId', null, ['class' => 'form-control']) !!}
</div>

<!-- Emailid Manual Field -->
<div class="form-group col-sm-6">
    {!! Form::label('emailId_manual', 'Emailid Manual:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('emailId_manual', false) !!}
        {!! Form::checkbox('emailId_manual', '1', null) !!} 1
    </label>
</div>

<!-- Status Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status_id', 'Status Id:') !!}
    {!! Form::number('status_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Id Manual Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status_id_manual', 'Status Id Manual:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('status_id_manual', false) !!}
        {!! Form::checkbox('status_id_manual', '1', null) !!} 1
    </label>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('cargos.index') !!}" class="btn btn-default">Cancel</a>
</div>

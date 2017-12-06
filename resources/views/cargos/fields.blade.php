<!-- Customer Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer_id', 'Customer Id:') !!}
    {!! Form::number('customer_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Loading Port Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loading_port', 'Loading Port:') !!}
    {!! Form::number('loading_port', null, ['class' => 'form-control']) !!}
</div>

<!-- Discharging Port Field -->
<div class="form-group col-sm-6">
    {!! Form::label('discharging_port', 'Discharging Port:') !!}
    {!! Form::number('discharging_port', null, ['class' => 'form-control']) !!}
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
</div>

<!-- Sf Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sf_unit', 'Sf Unit:') !!}
    {!! Form::number('sf_unit', null, ['class' => 'form-control']) !!}
</div>

<!-- Ship Specialization Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ship_specialization_id', 'Ship Specialization Id:') !!}
    {!! Form::number('ship_specialization_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Quantity Measurement Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity_measurement_id', 'Quantity Measurement Id:') !!}
    {!! Form::number('quantity_measurement_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Quantity Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantity', 'Quantity:') !!}
    {!! Form::number('quantity', null, ['class' => 'form-control']) !!}
</div>

<!-- Loading Rate Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loading_rate_type', 'Loading Rate Type:') !!}
    {!! Form::number('loading_rate_type', null, ['class' => 'form-control']) !!}
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
</div>

<!-- Discharging Rate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('discharging_rate', 'Discharging Rate:') !!}
    {!! Form::number('discharging_rate', null, ['class' => 'form-control']) !!}
</div>

<!-- Freight Idea Measurement Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('freight_idea_measurement_id', 'Freight Idea Measurement Id:') !!}
    {!! Form::number('freight_idea_measurement_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Freight Idea Field -->
<div class="form-group col-sm-6">
    {!! Form::label('freight_idea', 'Freight Idea:') !!}
    {!! Form::number('freight_idea', null, ['class' => 'form-control']) !!}
</div>

<!-- Extra Condition Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('extra_condition', 'Extra Condition:') !!}
    {!! Form::textarea('extra_condition', null, ['class' => 'form-control']) !!}
</div>

<!-- Comission Field -->
<div class="form-group col-sm-6">
    {!! Form::label('comission', 'Comission:') !!}
    {!! Form::number('comission', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('cargos.index') !!}" class="btn btn-default">Cancel</a>
</div>

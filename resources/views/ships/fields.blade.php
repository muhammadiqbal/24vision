<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Imo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('imo', 'Imo:') !!}
    {!! Form::text('imo', null, ['class' => 'form-control']) !!}
</div>

<!-- Year Of Build Field -->
<div class="form-group col-sm-6">
    {!! Form::label('year_of_build', 'Year Of Build:') !!}
    {!! Form::date('year_of_build', null, ['class' => 'form-control']) !!}
</div>

<!-- Dwcc Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dwcc', 'Dwcc:') !!}
    {!! Form::number('dwcc', null, ['class' => 'form-control']) !!}
</div>

<!-- Max Holds Capacity Field -->
<div class="form-group col-sm-6">
    {!! Form::label('max_holds_capacity', 'Max Holds Capacity:') !!}
    {!! Form::number('max_holds_capacity', null, ['class' => 'form-control']) !!}
</div>

<!-- Ballast Draft Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ballast_draft', 'Ballast Draft:') !!}
    {!! Form::number('ballast_draft', null, ['class' => 'form-control']) !!}
</div>

<!-- Max Laden Draft Field -->
<div class="form-group col-sm-6">
    {!! Form::label('max_laden_draft', 'Max Laden Draft:') !!}
    {!! Form::number('max_laden_draft', null, ['class' => 'form-control']) !!}
</div>

<!-- Draft Per Tonnage Field -->
<div class="form-group col-sm-6">
    {!! Form::label('draft_per_tonnage', 'Draft Per Tonnage:') !!}
    {!! Form::number('draft_per_tonnage', null, ['class' => 'form-control']) !!}
</div>

<!-- Speed Laden Field -->
<div class="form-group col-sm-6">
    {!! Form::label('speed_laden', 'Speed Laden:') !!}
    {!! Form::number('speed_laden', null, ['class' => 'form-control']) !!}
</div>

<!-- Speed Ballast Field -->
<div class="form-group col-sm-6">
    {!! Form::label('speed_ballast', 'Speed Ballast:') !!}
    {!! Form::number('speed_ballast', null, ['class' => 'form-control']) !!}
</div>

<!-- Fuel Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fuel_type_id', 'Fuel Type Id:') !!}
    {!! Form::number('fuel_type_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Fuel Consumption At Sea Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fuel_consumption_at_sea', 'Fuel Consumption At Sea:') !!}
    {!! Form::number('fuel_consumption_at_sea', null, ['class' => 'form-control']) !!}
</div>

<!-- Fuel Consumption In Port Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fuel_consumption_in_port', 'Fuel Consumption In Port:') !!}
    {!! Form::number('fuel_consumption_in_port', null, ['class' => 'form-control']) !!}
</div>

<!-- Flag Field -->
<div class="form-group col-sm-6">
    {!! Form::label('flag', 'Flag:') !!}
    {!! Form::text('flag', null, ['class' => 'form-control']) !!}
</div>

<!-- Ship Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ship_type_id', 'Ship Type Id:') !!}
    {!! Form::number('ship_type_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Ship Specialization Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ship_specialization_id', 'Ship Specialization Id:') !!}
    {!! Form::number('ship_specialization_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Gear Onboard Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('gear_onboard', 'Gear Onboard:') !!}
    {!! Form::textarea('gear_onboard', null, ['class' => 'form-control']) !!}
</div>

<!-- Additional Information Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('additional_information', 'Additional Information:') !!}
    {!! Form::textarea('additional_information', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('ships.index') !!}" class="btn btn-default">Cancel</a>
</div>

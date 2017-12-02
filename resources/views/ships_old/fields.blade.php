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

<!-- Year Of Built Field -->
<div class="form-group col-sm-6">
    {!! Form::label('year_of_built', 'Year Of Built:') !!}
    {!! Form::date('year_of_built', null, ['class' => 'form-control']) !!}
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

<!-- Max Laden Draft Field -->
<div class="form-group col-sm-6">
    {!! Form::label('max_laden_draft', 'Max Laden Draft:') !!}
    {!! Form::number('max_laden_draft', null, ['class' => 'form-control']) !!}
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
    <select name="ship_type_id" class="form-control">
        @foreach($shipTypes as $shipType)
            <option value="{{$shipType->id}}">{{$shipType->name}}</option>
        @endforeach
    </select>
</div>

<!-- Ship Specialization Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ship_specialization_id', 'Ship Specialization Id:') !!}
        <select name="ship_specialization_id" class="form-control">
        @foreach($shipSpecializations as $shipSpecialization)
            <option value="{{$shipSpecialization->id}}">{{$shipSpecialization->name}}</option>
        @endforeach
    </select>
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

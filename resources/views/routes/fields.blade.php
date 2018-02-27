<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Bdi Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('bdi_id', 'Bdi Id:') !!}
    <select name="bdi_id" class="form-control">
    	@foreach($bdis as $bdi)
    		<option value="{{$bdi->id}}">{{$bdi->name}}</option>
    	@endforeach
    </select>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('routes.index') !!}" class="btn btn-default">Cancel</a>
</div>

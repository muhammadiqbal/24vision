<!-- Subject Field -->
<div class="form-group col-sm-6">
    {!! Form::label('subject', 'Subject:') !!}
    {!! Form::text('subject', null, ['class' => 'form-control']) !!}
</div>

<!-- Body Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('body', 'Body:') !!}
    {!! Form::textarea('body', null, ['class' => 'form-control']) !!}
</div>

<!-- Sender Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sender', 'Sender:') !!}
    {!! Form::text('sender', null, ['class' => 'form-control']) !!}
</div>

<!-- Receiver Field -->
<div class="form-group col-sm-6">
    {!! Form::label('receiver', 'Receiver:') !!}
    {!! Form::text('receiver', null, ['class' => 'form-control']) !!}
</div>

<!-- Cc Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cc', 'Cc:') !!}
    {!! Form::text('cc', null, ['class' => 'form-control']) !!}
</div>

<!-- Classification Manual Field -->
<div class="form-group col-sm-6">
    {!! Form::label('classification_manual', 'Classification Manual:') !!}
    {!! Form::text('classification_manual', null, ['class' => 'form-control']) !!}
</div>

<!-- Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date', 'Date:') !!}
    {!! Form::date('date', null, ['class' => 'form-control']) !!}
</div>

<!-- Classification Automated Field -->
<div class="form-group col-sm-6">
    {!! Form::label('classification_automated', 'Classification Automated:') !!}
    {!! Form::text('classification_automated', null, ['class' => 'form-control']) !!}
</div>

<!-- Imapuid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('IMAPUID', 'Imapuid:') !!}
    {!! Form::text('IMAPUID', null, ['class' => 'form-control']) !!}
</div>

<!-- Imapfolderid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('IMAPFolderID', 'Imapfolderid:') !!}
    {!! Form::number('IMAPFolderID', null, ['class' => 'form-control']) !!}
</div>

<!--  Created On Field -->
<div class="form-group col-sm-6">
    {!! Form::label('_created_on', ' Created On:') !!}
    {!! Form::date('_created_on', null, ['class' => 'form-control']) !!}
</div>

<!-- Classification Automated Certainty Field -->
<div class="form-group col-sm-6">
    {!! Form::label('classification_automated_certainty', 'Classification Automated Certainty:') !!}
    {!! Form::number('classification_automated_certainty', null, ['class' => 'form-control']) !!}
</div>

<!-- Kibana Extracted Field -->
<div class="form-group col-sm-6">
    {!! Form::label('kibana_extracted', 'Kibana Extracted:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('kibana_extracted', false) !!}
        {!! Form::checkbox('kibana_extracted', '1', null) !!} 1
    </label>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('emails.index') !!}" class="btn btn-default">Cancel</a>
</div>

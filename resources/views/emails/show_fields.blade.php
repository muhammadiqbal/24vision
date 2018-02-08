<!-- Emailid Field -->
<div class="form-group">
    {!! Form::label('emailID', 'Emailid:') !!}
    <p>{!! $email->emailID !!}</p>
</div>

<!-- Subject Field -->
<div class="form-group">
    {!! Form::label('subject', 'Subject:') !!}
    <p>{!! $email->subject !!}</p>
</div>

<!-- Body Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('body', 'Body:') !!}
    <textarea class="form-control" readonly="true">{!! $email->body !!}</textarea>
</div>

<!-- Sender Field -->
<div class="form-group">
    {!! Form::label('sender', 'Sender:') !!}
    <p>{!! $email->sender !!}</p>
</div>

<!-- Receiver Field -->
<div class="form-group">
    {!! Form::label('receiver', 'Receiver:') !!}
    <p>{!! $email->receiver !!}</p>
</div>

<!-- Cc Field -->
<div class="form-group">
    {!! Form::label('cc', 'Cc:') !!}
    <p>{!! $email->cc !!}</p>
</div>

<!-- Classification Manual Field -->
<div class="form-group">
    {!! Form::label('classification_manual', 'Classification Manual:') !!}
    <p>{!! $email->classification_manual !!}</p>
</div>

<!-- Date Field -->
<div class="form-group">
    {!! Form::label('date', 'Date:') !!}
    <p>{!! $email->date !!}</p>
</div>

<!-- Classification Automated Field -->
<div class="form-group">
    {!! Form::label('classification_automated', 'Classification Automated:') !!}
    <p>{!! $email->classification_automated !!}</p>
</div>

<!-- Imapuid Field -->
<div class="form-group">
    {!! Form::label('IMAPUID', 'Imapuid:') !!}
    <p>{!! $email->IMAPUID !!}</p>
</div>

<!-- Imapfolderid Field -->
<div class="form-group">
    {!! Form::label('IMAPFolderID', 'Imapfolderid:') !!}
    <p>{!! $email->IMAPFolderID !!}</p>
</div>

<!--  Created On Field -->
<div class="form-group">
    {!! Form::label('_created_on', ' Created On:') !!}
    <p>{!! $email->_created_on !!}</p>
</div>

<!-- Classification Automated Certainty Field -->
<div class="form-group">
    {!! Form::label('classification_automated_certainty', 'Classification Automated Certainty:') !!}
    <p>{!! $email->classification_automated_certainty !!}</p>
</div>

<!-- Kibana Extracted Field -->
<div class="form-group">
    {!! Form::label('kibana_extracted', 'Kibana Extracted:') !!}
    <p>{!! $email->kibana_extracted !!}</p>
</div>


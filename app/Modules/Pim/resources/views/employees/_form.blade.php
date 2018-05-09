<div class="form-group">
    {!! Form::label('first_name', trans('app.pim.employees.first_name').':', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('father_name', 'Father Name:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('father_name', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('last_name', trans('app.pim.employees.last_name').':', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('matricola', 'Matricola:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('matricola', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('id_card', 'ID Card:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('id_card', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('email', 'Company Email:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::input('email', 'email', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('personal_email', 'Personal Email:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::input('email', 'personal_email', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('contact', 'Mobile:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('contact', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('emergency_contact', 'Emergency Contact:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('emergency_contact', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('structure', 'Structure:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::select('structure', $structure, null, ['class' => 'form-control projects']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('supervisor', 'Structure:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::select('supervisor', $users, null, ['class' => 'form-control projects']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('profession', 'Job Position:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('profession', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('bank_account', 'Bank Account:', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::text('bank_account', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('gender', trans('app.pim.employees.gender').':', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::label('male', trans('app.pim.employees.gender_male')) !!}
        {!! Form::radio('gender', 'm', @$employee->gender == 'm', ['id' => 'male']) !!}
        {!! Form::label('female', trans('app.pim.employees.gender_female')) !!}
        {!! Form::radio('gender', 'f', @$employee->gender == 'f', ['id' => 'female']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('birth_date', trans('app.pim.employees.birth_date').':', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::input('date', 'birth_date', null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('notes', trans('app.pim.employees.notes').':', ['class' => 'col-sm-3']) !!}
    <div class="col-sm-6">
        {!! Form::textarea('notes', null, ['class' => 'form-control']) !!}
    </div>
</div>
@include('errors._form-errors')
<hr>
<div class="form-group">
    <div class="col-sm-6 col-sm-offset-3">
        <a href="{{route('pim.employees.index')}}" class="btn btn-default">{{trans('app.cancel')}}</a>
        {!! Form::submit($submitName, ['class' => 'btn btn-primary']) !!}
    </div>
</div>
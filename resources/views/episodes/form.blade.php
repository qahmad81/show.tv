<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('series_id') }}
            {{ Form::select('series_id', $serieses, $episode->series_id, ['class' => 'form-control' . ($errors->has('series_id') ? ' is-invalid' : '')]) }}
            {!! $errors->first('series_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('title') }}
            {{ Form::text('title', $episode->title, ['class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : ''), 'placeholder' => 'Title']) }}
            {!! $errors->first('title', '<div class="invalid-feedback">:message</p>') !!}
        </div>

        <div class="form-group">
            {{ Form::label('description') }}
            {{ Form::textarea('description', $episode->description, ['class' => 'form-control' . ($errors->has('description') ? ' is-invalid' : ''), 'placeholder' => 'Description']) }}

            {!! $errors->first('description', '<div class="invalid-feedback">:message</p>') !!}
        </div>

        <div class="form-group">
            {{ Form::label('duration') }}
            {{ Form::text('duration', $episode->duration, ['class' => 'form-control' . ($errors->has('duration') ? ' is-invalid' : ''), 'placeholder' => 'Duration']) }}
            {!! $errors->first('duration', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('airing_time') }}
            {{ Form::text('airing_time', $episode->airing_time, ['class' => 'form-control' . ($errors->has('airing_time') ? ' is-invalid' : ''), 'placeholder' => 'Airing Time']) }}
            {!! $errors->first('airing_time', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('image') }}
            {{ Form::file('image', ['class' => 'form-control' . ($errors->has('image') ? ' is-invalid' : '')]) }}
            {!! $errors->first('image', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('video') }}
            {{ Form::file('video', ['class' => 'form-control' . ($errors->has('video') ? ' is-invalid' : '')]) }}
            {!! $errors->first('video', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>


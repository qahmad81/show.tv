@extends('layouts.app')

@section('template_title')
    {{ $episode->name ?? 'Show Episode' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Episode</span>
                        </div>
                        <div class="float-right">
                            @auth
                            @if (Auth::id() == 1)
                            <a class="btn btn-primary" href="{{ route('episodes.index') }}"> Back</a>
                            @else
                            <a class="btn btn-primary" href="{{ route('series.show',$episode->series->id) }}"> Back</a>
                            @endif
                            @endauth
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                        <div class="form-group col-6 flex-column justify-content-center">
                            @if (!empty($episode->image))
                                  <img src="{{ Storage::disk('episodes')->url($episode->image) }}" width="250">
                             @endif
                        </div>

                        <div  class="col-6">
                        <div class="form-group">
                            <strong>Series:</strong>
                            <a class="btn btn-light" href="{{ route('series.show',$episode->series->id) }}">{{ $episode->series->title }}</a>
                        </div>
                        <div class="form-group">
                            <strong>Title:</strong>
                            {{ $episode->title }}
                        </div>

                        <div class="form-group">
                            <strong>Duration:</strong>
                            {{ $episode->duration }}
                        </div>
                        <div class="form-group">
                            <strong>Airing Time:</strong>
                            {{ $episode->airing_time }}
                        </div>

                        </div>
                        </div>

                        <div class="form-group">
<video width="100%" controls>
  <source src="{{ Storage::disk('episodes')->url($episode->video) }}" type="video/{{ $episode->ext }}">
Your browser does not support the video tag.
</video>
                            
                        </div>


                        <div class="form-group">
                            <strong>Description:</strong>
                            {!! $episode->description !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

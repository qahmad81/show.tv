@extends('layouts.app')

@section('template_title')
    {{ 'Home Page' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Home Page</span>
                        </div>
                    </div>

                    <div class="row">
                    @foreach($episodes as $episode)
                    <div class="card-body col-6">
                        <div class="row">
                        <div class="form-group col-6 flex-column justify-content-center">
                            @if (!empty($episode->image))
                                  <img src="{{ Storage::disk('episodes')->url($episode->image) }}" width="250">
                             @endif
                        </div>

                        <div  class="col-6">
                        @if ($episode->series) 
                        <div class="form-group">
                            <strong>Series:</strong>
                            <a class="btn btn-light" href="{{ route('series.show',$episode->series->id) }}">{{ $episode->series->title }}</a>
                        </div>
                        @endif
                        <div class="form-group">
                            <strong>Title:</strong>
                            <a class="btn btn-light" href="{{ route('episodes.show',$episode->id) }}">{{ $episode->title }}</a>
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
                    </div>
                    @endforeach
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

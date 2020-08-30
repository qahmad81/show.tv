@extends('layouts.app')

@section('template_title')
    {{ $series->name ??  __('Show Series') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{  __('Show Series') }}</span>
                        </div>
                        <div class="float-right">
                            @auth
                            @if (Auth::id() == 1)
                            <a class="btn btn-primary" href="{{ route('series.index') }}"> {{  __('Back') }}</a>
                            @else
                            <a class="btn btn-primary" href="{{ url('/') }}"> {{  __('Back') }}</a>
                            @endif
                            @endauth
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-6">
                                <strong>{{  __('Title') }}:</strong>
                                {{ $series->title }}
                            </div>

                            <div class="form-group col-6">
                                <strong>{{  __('Airing Time') }}:</strong>
                                {{ $series->airing_time }}
                            </div>
                        </div>


                        <div class="form-group">
                            <strong>{{  __('Description') }}:</strong>
                            {!! $series->description !!}
                        </div>

                        <div class="row">
                            <div class="form-group col-2">
                                {{  __('followers') }}: 
                                <span id="followrs">{{ $series->followers->count() }}</span>
                            </div>
                            <div class="form-group col-10">
                            @if ($series->is_follow)
                                <button type="button" id="followbtn" onclick="toggleFollow()" class="btn btn-outline-primary">
                                {{  __('Following') }} </button>
                            @else
                                <button type="button" id="followbtn" onclick="toggleFollow()" class="btn btn-outline-secondary">
                                {{  __('Follow') }} </button>
                            @endif
                            </div>
                        </div>

                    </div>

                    <div class="row">
                    @foreach($series->episodes as $episode)
                    <div class="card-body col-6">
                        <div class="row">
                        <div class="form-group col-6 flex-column justify-content-center">
                            @if (!empty($episode->image))
                                  <img src="{{ Storage::disk('episodes')->url($episode->image) }}" width="250">
                             @endif
                        </div>

                        <div  class="col-6">
                        <div class="form-group">
                            <strong>Series:</strong>
                            {{ $episode->series->title }}
                        </div>
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
<script type="text/javascript">
    function toggleFollow() {
        if ($( "#followbtn" ).hasClass('btn-outline-secondary')) {
            $.ajax({
              url: "{{ url('series/follow/' . $series->id) }}",
              context: document.body
            }).done(function(followers) {
                $( "#followrs" ).text(followers);
                $( "#followbtn" ).removeClass( "btn-outline-secondary" );
                $( "#followbtn" ).addClass( "btn-outline-primary" );
                $( "#followbtn" ).text( "{{ __('Following') }}" );
            });
        } else {
        $.ajax({
          url: "{{ url('series/unfollow/' . $series->id) }}",
          context: document.body
        }).done(function(followers) {
            $( "#followrs" ).text(followers);
            $( "#followbtn" ).removeClass( "btn-outline-primary" );
            $( "#followbtn" ).addClass( "btn-outline-secondary" );
            $( "#followbtn" ).text( "{{ __('Follow') }}" );
        });
        }
    }
</script>
@endsection

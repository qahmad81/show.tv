@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                <div class="inline-block">{{ __('Series') }}</div>
                <div class="inline-block">
                    <a href="{{ route('series.create') }}" class="btn btn-primary">Add</a>
                </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <ul>
                    @foreach($serieses as $series)
                        @foreach($series->episodes as $episode)
                        @endforeach
                    @endforeach

                    <show-series-component :serieses="{{$serieses}}"></show-series-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

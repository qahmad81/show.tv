@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                <div class="inline-block">{{ __('Update Episode') }}</div>
                <div class="inline-block">
                    <a href="{{ route('episodes.index') }}" class="btn btn-secondary">Back</a>
                </div>
                </div>

                <div class="card-body">
                    <h3>{{ __('Edit Series') }}</h3>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <edit-episode-component :serieses="{{$serieses}}" :episode="{{$episode}}" submiturl="{{$submiturl}}" token1="{{csrf_token()}}"></edit-episode-component>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

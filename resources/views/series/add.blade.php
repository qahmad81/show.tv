@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                <div class="inline-block">{{ __('Series') }}</div>
                <div class="inline-block">
                    <a href="{{ route('series.index') }}" class="btn btn-secondary">Back</a>
                </div>
                </div>

                <div class="card-body">
                    <h3>{{ __('Add new Series') }}</h3>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{ route('series.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group mt-4">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title">
                        @error('title')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mt-4">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                        @error('description')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mt-4">
                        <label for="airing_time">Airing Time</label>
                        <input type="text" class="form-control" id="airing_time" name="airing_time">
                        @error('airing_time')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Submit The Series</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                <div class="inline-block">{{ __('Episodes') }}</div>
                <div class="inline-block">
                    <a href="{{ route('series.index') }}" class="btn btn-secondary">Back</a>
                </div>
                </div>

                <div class="card-body">
                    <h3>{{ __('Add new Episodes') }}</h3>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{ route('episodes.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group mt-4">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title">
                        @error('title')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mt-4">
                        <label for="series_id">Select Series</label>
                        <select class="form-control" id="series_id" name="series_id">
                        @foreach($serieses as $series)
                            <option value="{{$series->id}}">{{$series->title}}</option>
                        @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group mt-4">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description"></textarea>
                        @error('description')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-4">
                        <label for="duration">Duration</label>
                        <input type="text" class="form-control" name="duration">
                        @error('duration')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-4">
                        <label for="airing_time">Airing Time</label>
                        <input type="text" class="form-control" name="airing_time">
                        @error('airing_time')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                                       
                    <div class="form-group mt-4">
                        <label for="image">Image</label>
                        <input type="text" class="form-control" name="image">
                        @error('image')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-4">
                        <label for="video">Video</label>
                        <input type="text" class="form-control" name="video">
                        @error('video')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
  
                    <button type="submit" class="btn btn-primary">Submit The Episodes</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

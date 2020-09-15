@extends('layouts.app')

@section('template_title')
    Update Series
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">
                    @if ($message)
                        <div class="alert alert-danger">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    @if ($theError = Session::get('error'))
                        <div class="alert alert-danger">
                            <p>{{ $theError }}</p>
                        </div>
                    @endif

            </div>
        </div>
    </section>
@endsection

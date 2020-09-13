@extends('layouts.app')

@section('template_title')
    Episode
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Episode') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('episodes.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
										<th>Title</th>
                                        <th>Series</th>
										<th>Duration</th>
										<th>Airing Time</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($episodes as $episode)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $episode->title }}</td>
                                            <td>{{ $episode->series->title }}</td>
											<td>{{ $episode->duration }}</td>
											<td>{{ $episode->airing_time }}</td>

                                            <td>
                                                <form action="{{ route('episodes.destroy',$episode->id) }}" 
                                                    onsubmit="return confirm('Are you sure for delete?');" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('episodes.show',$episode->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('episodes.edit',$episode->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $episodes->links() !!}
            </div>
        </div>
    </div>
@endsection

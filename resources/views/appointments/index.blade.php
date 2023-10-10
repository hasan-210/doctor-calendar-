@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Appointments</h2>
            </div>
            <div class="pull-right">
                @can('appointment-create')
                <a class="btn btn-success" href="{{ route('appointments.create') }}"> Create New appointment</a>
                @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Details</th>
            <th>startDateTime</th>
            <th>endDateTime</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($appointments as $appointment)
	    <tr>
	        <td>{{ $appointment->id }}</td>
	        <td>{{ $appointment->name }}</td>
	        <td>{{ $appointment->description }}</td>
	        <td>{{ $appointment->startDateTime }}</td>
	        <td>{{ $appointment->endDateTime }}</td>
	        <td>
                <form action="{{ route('appointments.destroy',$appointment->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('appointments.show',$appointment->id) }}">Show</a>
                    @can('appointment-edit')
                    <a class="btn btn-primary" href="{{ route('appointments.edit',$appointment->id) }}">Edit</a>
                    @endcan


                    @csrf
                    @method('DELETE')
                    @can('appointment-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>





<p class="text-center text-primary"><small>Tutorial by ItSolutionStuff.com</small></p>
@endsection

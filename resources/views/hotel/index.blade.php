@extends('adminlte::page')

@section('title', 'Hotel Management')

@section('content_header')
    <h1>Hotel Management</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('hotel.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <select class="form-control" name="city">
                            <option value="">--Select City--</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="hotel_code" class="form-control" placeholder="Hotel Code">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="name" class="form-control" placeholder="Hotel Name">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body">
            <a href="{{ route('hotel.create') }}" class="btn btn-success mb-3 float-lg-right">Add New Hotel</a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>City</th>
                        <th>Hotel Code</th>
                        <th>Hotel Name</th>
                        <th>Hotel Class</th>
                        <th>Email</th>
                        <th>Telephone</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                     @if($hotels->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center">No data found</td>
                    </tr>
                    @else
                        @foreach($hotels as $hotel)
                            <tr>
                                <td>{{ $hotel->city }}</td>
                                <td><span class="badge badge-info">{{ $hotel->hotel_code }}</span></td>
                                <td>{{ $hotel->name }}</td>
                                <td>{{ $hotel->class }}</td>
                                <td>{{ $hotel->email }}</td>
                                <td>{{ $hotel->telephone }}</td>
                                <td>{{ $hotel->address }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">View</a>
                                    <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

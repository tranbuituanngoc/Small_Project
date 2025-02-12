@extends('adminlte::page')

@section('title', 'New Hotel')

@section('content_header')
    <h1>New Hotel</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">New Hotel</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('hotel.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Hotel Name *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="city_id">City *</label>
                        <select class="form-control" name="city">
                            <option value="">--Select City--</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tel">Telephone</label>
                        <input type="text" name="tel" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="address1">Address 1</label>
                        <textarea name="address1" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="hotel_code">Hotel Code</label>
                        <input type="text" name="hotel_code" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="fax">FAX</label>
                        <input type="text" name="fax" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="company_name">Company Name</label>
                        <input type="text" name="company_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tax_code">Tax Code</label>
                        <input type="text" name="tax_code" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="address2">Address 2</label>
                        <textarea name="address2" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <a href="{{ route('hotel.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
@stop

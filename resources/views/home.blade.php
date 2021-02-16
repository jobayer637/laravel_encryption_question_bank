@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Information') }}</div>
                @if(Auth::check() && ((Auth::user()->status != 1)))
                    <div class="card-body">
                        <h4>Your Request is Pending..</h4>
                        <h5>Please waiting for admin approval</h5>
                    </div>
                    <div class="card-body border">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>User Email</th>
                                    <th>User Phone</th>
                                    <th>Institute</th>
                                    <th>EIIN</th>
                                    <th>Board</th>
                                    <th>Division</th>
                                    <th>District</th>
                                    <th>Upazila</th>
                                    <th>Union</th>
                                </tr>
                            </thead>
                            <tbody>
                                <td>{{ Auth::user()->name }}</td>
                                <td>{{ Auth::user()->email }}</td>
                                <td>{{ Auth::user()->phone }}</td>
                                <td>{{ Auth::user()->institute->name }}</td>
                                <td>{{ Auth::user()->institute->eiin }}</td>
                                <td>{{ Auth::user()->institute->board->name }}</td>
                                <td>{{ Auth::user()->institute->division->name }}</td>
                                <td>{{ Auth::user()->institute->district->name }}</td>
                                <td>{{ Auth::user()->institute->upazila->name }}</td>
                                <td>{{ Auth::user()->institute->union->name }}</td>
                            </tbody>
                        </table>

                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

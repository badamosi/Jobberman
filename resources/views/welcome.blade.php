@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools float-left">
                        <h3>Companies </h3>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered table-responsive1 table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Company</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($companies as $key => $company)
                                <tr>
                                    <td>{{ 1 }}</td>
                                    <td>{{ $company->admin->fullname }}</td>
                                    <td>{{ $company->admin->email }}</td>
                                    <td>{{ $company->name }}</td>
                                </tr>
                            @endforeach  
                        </tbody>
                    </table>
                    
                </div>

                <!-- /.card-body -->
            
            </div>
            
        </div>
    </div>
</div>
@endsection
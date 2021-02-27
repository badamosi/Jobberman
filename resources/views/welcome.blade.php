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
                            </tr>
                        </thead>
                        <tbody>
                            <?php $n = 1 ?>
                            @foreach ($companies as $key => $company)
                                <tr>
                                    <td>{{ $n++ }}</td>
                                    <td><img src="{{$company->logo}}" height="65" width="65" />{{ $company->name }}</td>
                                    <td>{{ $company->admin->email }}</td>
                                </tr>
                            @endforeach  
                        </tbody>
                    </table>
                    <br>
                    

                    {{$companies->links(("pagination::bootstrap-4"))}}

                    
                </div>

                <!-- /.card-body -->
            
            </div>
            
        </div>
    </div>
</div>
@endsection
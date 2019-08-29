@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{  __('Dashboard') }}
                    <a href="{{ route('showTaskCreationForm') }}" class="btn btn-sm btn-success" style="float:right"><i class="fas fa-add"></i> {{ __('Add New Task') }} </a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                                @include('includes.logs')
                            <div class="card">
                                <div class="card-header bg-info text-white text-uppercase">{{ __('Most Recent tasks') }}</div>
                                <div class="card-body">
                                    <table class="table table-bordered table-responsive table-stripped" style="width:100%">
                                            @if(count($tasks) > 0)
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Title</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                    @foreach($tasks as $key => $value)
                                                        <tbody>
                                                            <tr>
                                                                <td>{{ $value->id }}</td>
                                                                <td>{{ $value->title }}</td>
                                                                <td>{{ $value->description }}</td>
                                                                <td>{{ $value->status }}</td>
                                                                <td class="btn-group btn-group-sm text-center" style="width:100%">
                                                                    @if($value->status === 'incomplete')
                                                                        <form method="post" action="{{ route('changeStatus', ['id'=>$value->id]) }}">
                                                                            {{ csrf_field() }}
                                                                            <button class="btn-primary btn-sm" type="submit">
                                                                                    Mark as complete
                                                                            </button>
                                                                        </form>
                                                                    @endif
                                                                    <a href="{{ route('editTask', ['id'=>$value->id])}}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                                                    <form action="{{ route('deleteTask',['id'=>$value->id]) }}" method="post">
                                                                        {{ csrf_field() }}
                                                                        <button class="btn btn-sm btn-danger" type="submit" onclick="if(!confirm('Are you sure you want to proceed?')){ return false}">
                                                                            <i class="fas fa-trash"></i> Delete
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    @endforeach
                                            @else
                                                <tr>
                                                    <td class="alert alert-warning">You have not added any tasks yet</td>
                                                </tr>
                                            @endif
                                    </table>
                
                                </div>
                                <div class="card-footer bg-dark">
                
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

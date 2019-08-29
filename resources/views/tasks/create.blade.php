@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            @include('includes.logs')
            <div class="card">
                <div class="card-header bg-info text-white text-uppercase">{{ __('Add New Task') }}</div>
                <div class="card-body">
                        {!! Form::open(['action'=>'Tasks\TasksController@store','method'=>'post'])!!}
                        <div class="form-group row">
                            {!! Form::label('title','Title',['class'=>'col-md-4 form-label text-md-right'])!!}
                            <div class="col-md-8">
                                {!! Form::text('title','',['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('description','Description',['class'=>'col-md-4 form-label text-md-right']) !!}
                            <div class="col-md-8">
                                {!! Form::textarea('description','',['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group" style="float:right">
                        <div class="col-md-8 col-md-offset-0">
                            <button class="btn btn-success btn-sm" type="submit">
                                <i class="fas fa-send"></i> Create
                            </button>
                        </div>
                        </div>
                        <div class="form-group" style="float:left">
                           <a href="{{ route('home') }}" class="btn btn-primary btn-sm">Cancel</a>
                        </div>
                    {!! Form::close()!!}
                </div>
                <div class="card-footer bg-dark">

                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
@endsection
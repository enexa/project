<!-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Admin Panel') }}</div>

                    <div class="card-body">
                        <ul>
                            <li><a href="{{ route('admin.create.teacher') }}">Register Teacher</a></li>
                            <li><a href="{{ route('admin.list.students') }}">List Students</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

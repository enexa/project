@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">{{ __('Admin Panel') }}</div>

                    <div class="card-body d-flex justify-content-center">
  <div class="btn-group-vertical">
    <a href="{{ route('admin.create.teacher') }}" class="btn btn-primary mb-3">Register Teacher</a>
    <a href="{{ route('admin.list.students') }}" class="btn btn-primary mb-3">List Students</a>
    <a href="{{ route('admin.list.teachers') }}" class="btn btn-primary">List Teachers</a>
  </div>
</div>

                </div>
            </div>
        </div>
    </div>
@endsection

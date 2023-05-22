@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">{{ __('Admin Panel') }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="btn-group-vertical">
                                <div class="avatar-container">
                                    <img src="{{ asset('image/notify.png') }}" alt="Avatar" class="avatar">
                                </div>
                                <br>
                                    <a href="{{ route('admin.create.teacher') }}" class="btn btn-primary mb-3">Register Teacher</a>
                                    <a href="{{ route('admin.list.teachers') }}" class="btn btn-primary mb-3">List Teachers</a>
                                    <a href="{{ route('admin.pdf.upload') }}" class="btn btn-primary mb-3">Upload PDF</a>
                                    <a href="{{ route('admin.pdf.upload') }}" class="btn btn-primary">Customer Service</a>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h1>Students</h1>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Department</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $student)
                                            <tr>
                                                <td>{{ $student->name }}</td>
                                                <td>{{ $student->email }}</td>
                                                <td>{{ $student->department }}</td>
                                                <td>
                                                    <form action="{{ route('admin.delete.student', $student->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

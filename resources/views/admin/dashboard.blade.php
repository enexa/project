@extends('layouts.app')

@section('content')
    <h1>Admin Dashboard</h1>

    <h2>Students</h2>
    <ul>
        @foreach ($students as $student)
            <li>{{ $student->name }} - {{ $student->email }}</li>
        @endforeach
    </ul>

    <h2>Teachers</h2>
    <ul>
        @foreach ($teachers as $teacher)
            <li>{{ $teacher->name }} - {{ $teacher->email }}</li>
        @endforeach
    </ul>
@endsection

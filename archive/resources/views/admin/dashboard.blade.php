@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Admin Dashboard</h1>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <table class="table">
            <thead>
                <tr>
                    <th>Project Name</th>
                    <th>Members</th>
                    <th>Abstract</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($researches as $research)
                    <tr>
                        <td>{{ $research->project_name }}</td>
                        <td>{{ $research->members }}</td>
                        <td>{{ $research->abstract }}</td>
                        <td>
                            <form action="{{ route('research.approve', $research->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success">Approve</button>
                            </form>
                            <form action="{{ route('research.reject', $research->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Reject</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
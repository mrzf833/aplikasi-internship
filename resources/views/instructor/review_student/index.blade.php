@extends('instructor.layout.layout')
@section('judul')
    Student
@endsection
@section('content')
<div class="mt-4">
    <div class="table-responsive table--no-card m-b-30">
        <table class="table table-borderless table-striped table-earning">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name Student</th>
                    <th>Mentor</th>
                    <th>Name Project</th>
                    <th>Description Project</th>
                    <th>Url Project</th>
                    <th>Score</th>
                    <th>Comment</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $student->users()->first()->fullname }}</td>
                        @forelse ($student->users()->first()->user_reviews()->get() as $project)
                            <td>{{ $project->mentors()->first()->fullname }}</td>
                            <td>{{ $project->projects()->first()->name }}</td>
                            <td>{{ $project->projects()->first()->description }}</td>
                            <td>{{ $project->projects()->first()->url }}</td>
                            <td>{{ $project->score != '' ?:'belum di nilai' }}</td>
                            <td>{{ $project->comment != '' ?:'belum di nilai'  }}</td>
                        @empty
                            <td colspan="6"><p class="btn btn-danger">Belum Ada Project</p></td>
                        @endforelse
                    </tr>
                @empty
                    
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
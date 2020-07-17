@extends('mentor.layout.layout')
@section('judul')
Review Student
@endsection
@section('modals')
@forelse ($modals as $modal)
<div class="modal fade" id="review-{{ $modal->id }}" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Review {{ $modal->users()->first()->fullname }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('mentor.review_student',$modal->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="control-label">Name Project</label>
                        <input type="text" name="" id="" class="form-control" value="{{ $modal->projects()->first()->name }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Description Project</label>
                        <textarea name="" id="" cols="30" rows="2" class="form-control" disabled>{{ $modal->projects()->first()->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Url Project</label>
                        <input type="text" name="" id="" class="form-control" value="{{ $modal->projects()->first()->url }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Score Project</label>
                        <select name="score" id="" class="form-control" content="{{ $modal->score }}">
                            <option value="A" {{ $modal->score === 'A' ? 'selected' : '' }}>A: Sangat Bagus</option>
                            <option value="B" {{ $modal->score === 'B' ? 'selected' : '' }}>B: Bagus</option>
                            <option value="C" {{ $modal->score === 'C' ? 'selected' : '' }}>C: Cukup</option>
                            <option value="D" {{ $modal->score === 'D' ? 'selected' : '' }}>D: Kurang</option>
                            <option value="E" {{ $modal->score === 'E' ? 'selected' : '' }}>E: Sangat Kurang</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Comment</label>
                        <textarea name="comment" id="" cols="30" rows="2" class="form-control" content="{{ $modal->comment }}">{{ $modal->comment }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@empty
    
@endforelse
@endsection
@section('content')
<div class="">
    <div class="table-responsive table--no-card m-b-30 mt-4">
        <table class="table table-borderless table-striped table-earning">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Instruktur</th>
                    <th>Student</th>
                    <th>Name Project</th>
                    <th>Description Project</th>
                    <th>Url Project</th>
                    <th>Score Project</th>
                    <th>Comment</th>
                    <th class=" text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mentors as $instructor)
                <tr>
                    <td rowspan="{{ count($instructor) + '3' }}">{{ $loop->iteration }}</td>
                    <td rowspan="{{ count($instructor) + '3' }}">{{ $instructor[0]->name_instructor }}</td>
                    @forelse ($instructor->groupBy('id_user') as $students )

                        @forelse ($students as $student)
                        @if ($loop->iteration == '1')
                            <tr>
                            <td rowspan="{{ count($students) }}">{{ $student->users()->first()->fullname }}</td>
                        @else
                        <tr>
                        @endif
                        <td>{{ $student->projects()->first()->name }}</td>
                        <td>{{ $student->projects()->first()->description }}</td>
                        <td>{{ $student->projects()->first()->url }}</td>
                        <td>{{ $student->score != '' ? $student->score : 'Belum DiReview' }}</td>
                        <td>{{ $student->comment != '' ? $student->comment : 'Belum DiReview'}}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-review" data-toggle="modal" data-target="#review-{{ $student->id }}">Review</button>
                            <form action="{{ route('mentor.review.delete',$student->id) }}" method="POST" class=" d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                        @empty
                            
                        @endforelse

                    @empty
                        
                    @endforelse

                @empty
                    <tr>
                        <td colspan="9">Maaf Data Belum Ada</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).on('click','.btn-review',function(){
            let modal_id = $(this).attr('data-target');
            let content_score = $(modal_id + ' [name="score"]').attr('content');
            let content_comment= $(modal_id + ' [name="comment"]').attr('content');
            $(modal_id + ' [name="score"]').val(content_score);
            $(modal_id + ' [name="comment"]').val(content_comment);
        });
    </script>
@endsection
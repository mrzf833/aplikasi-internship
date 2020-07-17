@extends('student.layout.layout')
@section('judul')
    Project
@endsection
@section('btn-add')
<button class="au-btn au-btn-icon au-btn--blue" type="button" data-toggle="modal" data-target="#add-project">
    <i class="zmdi zmdi-plus"></i>add project
</button>
@endsection
@section('style')
    <style>
        .switch.switch-text .switch-input:checked ~ .switch-handle{
            left: 54px;
        }
    </style>
@endsection
@section('modals')
<div class="modal fade" id="add-project" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('student.project.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="control-label">Name Project</label>
                        <input type="text" name="name" id="name" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label for="description" class="control-label">Description Project</label>
                        <textarea name="description" id="description" cols="30" rows="2" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="url" class="control-label">Url Project</label>
                        <input type="text" name="url" id="url" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label for="mentor" class="control-label">Mentor</label>
                        <select name="mentor" id="mentor" class="form-control">
                            <option value="">-- pilih --</option>
                            @forelse ($mentors as $mentor)
                                <option value="{{ $mentor->id }}">{{ $mentor->fullname }}</option>
                            @empty
                                
                            @endforelse
                        </select>
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
@forelse ($projects as $project)
<div class="modal fade" id="edit-project{{ $project->id }}" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Project {{ $project->projects()->first()->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('student.project.edit',$project->id_project) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="control-label">Name Project</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $project->projects()->first()->name }}" content="{{ $project->projects()->first()->name }}">
                    </div>
                    <div class="form-group">
                        <label for="description" class="control-label">Description Project</label>
                        <textarea name="description" id="description" cols="30" rows="2" class="form-control" content="{{ $project->projects()->first()->description }}">{{ $project->projects()->first()->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="url" class="control-label">Url Project</label>
                        <input type="text" name="url" id="url" class="form-control" value="{{ $project->projects()->first()->url }}" content="{{ $project->projects()->first()->url }}">
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
<div class="mt-4">
    <div class="table-responsive table--no-card m-b-30">
        <table class="table table-borderless table-striped table-earning">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Mentor</th>
                    <th>Name Project</th>
                    <th>Description Project</th>
                    <th>Url Project</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($projects as $project)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $project->mentors()->first()->fullname }}</td>
                        <td>{{ $project->projects()->first()->name }}</td>
                        <td>{{ $project->projects()->first()->description }}</td>
                        <td>{{ $project->projects()->first()->url }}</td>
                        <td>
                            <button type="button" class="btn btn-warning edit" data-toggle="modal" data-target="#edit-project{{ $project->id }}" >Edit</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">maaf data tidak ada</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).on('click','.edit',function(){
            let id = $(this).attr('data-target');
            let name = $(id + ' [name="name"]');
            let description = $(id + ' [name="description"]');
            let url = $(id + ' [name="url"]');
            name.val(name.attr('content'));
            description.val(description.attr('content'));
            url.val(url.attr('content'));
        });
    </script>
@endsection
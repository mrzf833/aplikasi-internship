@extends('admin.layout.layout')
@section('judul')
Instructor
@endsection
@section('btn-add')
<div>
    <button type="button" class="au-btn au-btn-icon au-btn--blue" data-toggle="modal" data-target="#add-instructor">
        <i class="zmdi zmdi-plus"></i>add Instructor
    </button>
</div>
@endsection
@section('modals')
<div class="modal fade" id="add-instructor" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Instructor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.instructors.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class=" form-group has-success">
                        <label for="fullname" class=" control-label mb-1">Nama Lengkap</label>
                        <input type="text" name="fullname" id="fullname" class="form-control" autocomplete="off">
                    </div>
                    <div class=" form-group has-success">
                        <label for="email" class=" control-label mb-1">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
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
@forelse ($instructors as $instructor)
<div class="modal fade" id="edit-instructor-{{ $instructor->id }}" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Instructor {{ $instructor->fullname }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.instructors.edit',$instructor->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class=" form-group has-success">
                        <label for="fullname" class=" control-label mb-1">Nama Lengkap</label>
                        <input type="text" name="fullname" id="fullname" class="form-control" autocomplete="off" content="{{ $instructor->fullname }}">
                    </div>
                    <div class=" form-group has-success">
                        <label for="email" class=" control-label mb-1">Email</label>
                        <input type="email" name="email" id="email" class="form-control" content="{{ $instructor->email }}">
                    </div>
                    <div class=" form-group has-success">
                        <label for="password" class=" control-label mb-1">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Jangan Diisi Kalau Tidak Mau Di Rubah">
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
    <div>
        <div class="mt-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between px-4" id="instructor" style="cursor: pointer;">
                    <div>Instructor</div>
                    <div><i class="fas"></i></div>
                </div>
                <div class="card-body" id="table-instructor">
                    <div class="table-responsive table--no-card m-b-10">
                        <table class="table table-borderless table-striped table-earning">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($instructors as $instructor)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $instructor->fullname }}</td>
                                        <td>{{ $instructor->email }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning edit" data-toggle="modal" data-target="#edit-instructor-{{ $instructor->id }}">Edit</button>
                                            <form action="{{ route('admin.instructor.destroy',$instructor->id) }}" method="post" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9">Data Belum ada</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            if($('#table-instructor').is(':hidden')){
                    $('#instructor i.fas').addClass('fa-plus');
                }else if($('#table-instructor').is(':visible')){
                    $('#instructor i.fas').addClass('fa-minus');
                }
            $(document).on('click','#instructor',function(){
                $('#table-instructor').slideToggle(400,function(){
                    if($('#table-instructor').is(':hidden')){
                        $('#instructor i.fas').removeClass('fa-minus').addClass('fa-plus');
                    }else if($('#table-instructor').is(':visible')){
                        $('#instructor i.fas').removeClass('fa-plus').addClass('fa-minus');
                    }
                });
            });
            $(document).on('click','.edit',function(){
                let id = $(this).attr('data-target');
                let fullname = $(id + ' [name="fullname"]');
                fullname.val(fullname.attr('content'));
                let email = $(id + ' [name="email"]');
                email.val(email.attr('content'));
            });
        });
    </script>
@endsection
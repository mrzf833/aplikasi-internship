@extends('admin.layout.layout')
@section('judul')
    Student
@endsection
@section('btn-add')
<div>
    <button class="au-btn au-btn-icon au-btn--blue" type="button" data-toggle="modal" data-target="#add-school">
        <i class="zmdi zmdi-plus"></i>add Sekolah
    </button>
    <a href="{{ route('admin.users.create') }}" class="au-btn au-btn-icon au-btn--blue">
        <i class="zmdi zmdi-plus"></i>add Student
    </a>
</div>
@endsection
@section('modals')
<div class="modal fade" id="add-school" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add School</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.school.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class=" form-group has-success">
                        <label for="name" class=" control-label mb-1">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="name school" autocomplete="off">
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
@endsection
@section('content')
    <div>
        <div class="mt-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between px-4" id="school" style="cursor: pointer;">
                    <div>Schools</div>
                    <div><i class="fas"></i></div>
                </div>
                <div class="card-body" id="table-school">
                    <div class="table-responsive table--no-card m-b-10">
                        <table class="table table-borderless table-striped table-earning">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($schools as $school)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $school->name }}</td>
                                        <td style="width:158px;height:62px">
                                            <form action="{{ route('admin.school.destroy',$school->id) }}" method="POST" class=" d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class=" btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                @empty
                                    <tr>
                                        <td colspan="3">Data Belum Ada</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between px-4" id="student" style="cursor: pointer;">
                    <div>Students</div>
                    <div><i class="fas"></i></div>
                </div>
                <div class="card-body" id="table-student" style="display: none">
                    <div class="table-responsive table--no-card m-b-10">
                        <table class="table table-borderless table-striped table-earning">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Email</th>
                                    <th>No Hp</th>
                                    <th>Asal Sekolah</th>
                                    <th>Tanggal Mulai Magang</th>
                                    <th>Tanggal Selesai Magang</th>
                                    <th>Flag</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $student)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->fullname }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->user_profiles()->first()->phone_number }}</td>
                                        <td>{{ $student->user_profiles()->first()->schools()->first()->name }}</td>
                                        <td>{{ $student->user_profiles()->first()->start_internship }}</td>
                                        <td>{{ $student->user_profiles()->first()->end_internship }}</td>
                                        <td>
                                            @if ($student->flag === '0')
                                                <p class="btn btn-danger">
                                                    Deactive
                                                </p>
                                            @else
                                                <p class="btn btn-info">
                                                    Active
                                                </p>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.users.show',$student->id) }}" class=" btn btn-warning">Edit</a>
                                            <form action="{{ route('admin.users.destroy',$student->id) }}" method="post" class="d-inline-block">
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
            if($('#table-school').is(':hidden')){
                    $('#school i.fas').addClass('fa-plus');
                }else if($('#table-school').is(':visible')){
                    $('#school i.fas').addClass('fa-minus');
                }
            $(document).on('click','#school',function(){
                $('#table-school').slideToggle(400,function(){
                    if($('#table-school').is(':hidden')){
                        $('#school i.fas').removeClass('fa-minus').addClass('fa-plus');
                    }else if($('#table-school').is(':visible')){
                        $('#school i.fas').removeClass('fa-plus').addClass('fa-minus');
                    }
                });
            });
            if($('#table-student').is(':hidden')){
                    $('#student i.fas').addClass('fa-plus');
                }else if($('#table-student').is(':visible')){
                    $('#student i.fas').addClass('fa-minus');
                }
            $(document).on('click','#student',function(){
                $('#table-student').slideToggle(400,function(){
                    if($('#table-student').is(':hidden')){
                        $('#student i.fas').removeClass('fa-minus').addClass('fa-plus');
                    }else if($('#table-student').is(':visible')){
                        $('#student i.fas').removeClass('fa-plus').addClass('fa-minus');
                    }
                });
            });
        });
    </script>
@endsection
@extends('admin.layout.layout')
@section('judul')
    Mentor
@endsection
@section('btn-add')
<div>
    <button class="au-btn au-btn-icon au-btn--blue" type="button" data-toggle="modal" data-target="#add-position">
        <i class="zmdi zmdi-plus"></i>add Position
    </button>
    <a href="{{ route('admin.mentors.create') }}" class="au-btn au-btn-icon au-btn--blue">
        <i class="zmdi zmdi-plus"></i>add Mentor
    </a>
</div>
@endsection
@section('modals')
<div class="modal fade" id="add-position" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Position</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.position.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class=" form-group has-success">
                        <label for="name" class=" control-label mb-1">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="name Position" autocomplete="off">
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
                <div class="card-header d-flex justify-content-between px-4" id="position" style="cursor: pointer;">
                    <div>Position</div>
                    <div><i class="fas"></i></div>
                </div>
                <div class="card-body" id="table-position" style="display: block">
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
                                @forelse ($positions as $position)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $position->name }}</td>
                                        <td style="width:158px;height:62px">
                                            <form action="{{ route('admin.position.destroy',$position->id) }}" method="POST" class=" d-inline-block">
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
                <div class="card-header d-flex justify-content-between px-4" id="mentor" style="cursor: pointer;">
                    <div>Mentors</div>
                    <div><i class="fas"></i></div>
                </div>
                <div class="card-body" id="table-mentor" style="display: none">
                    <div class="table-responsive table--no-card m-b-10">
                        <table class="table table-borderless table-striped table-earning">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Email</th>
                                    <th>Position</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($mentors as $mentor)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $mentor->fullname }}</td>
                                        <td>{{ $mentor->email }}</td>
                                        <td>{{ $mentor->user_profiles()->first()->positions()->first()->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.mentors.show',$mentor->id) }}" class=" btn btn-warning">Edit</a>
                                            <form action="{{ route('admin.mentors.destroy',$mentor->id) }}" method="post" class="d-inline-block">
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
            if($('#table-position').is(':hidden')){
                    $('#position i.fas').addClass('fa-plus');
                }else if($('#table-position').is(':visible')){
                    $('#position i.fas').addClass('fa-minus');
                }
            $(document).on('click','#position',function(){
                $('#table-position').slideToggle(400,function(){
                    if($('#table-position').is(':hidden')){
                        $('#position i.fas').removeClass('fa-minus').addClass('fa-plus');
                    }else if($('#table-position').is(':visible')){
                        $('#position i.fas').removeClass('fa-plus').addClass('fa-minus');
                    }
                });
            });
            if($('#table-mentor').is(':hidden')){
                    $('#mentor i.fas').addClass('fa-plus');
                }else if($('#table-mentor').is(':visible')){
                    $('#mentor i.fas').addClass('fa-minus');
                }
            $(document).on('click','#mentor',function(){
                $('#table-mentor').slideToggle(400,function(){
                    if($('#table-mentor').is(':hidden')){
                        $('#mentor i.fas').removeClass('fa-minus').addClass('fa-plus');
                    }else if($('#table-mentor').is(':visible')){
                        $('#mentor i.fas').removeClass('fa-plus').addClass('fa-minus');
                    }
                });
            });
        });
    </script>
@endsection
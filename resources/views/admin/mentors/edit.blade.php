@extends('admin.layout.layout')
@section('judul')
    Mentor
@endsection
@section('content')
    <div>
        <div class="mt-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3 class="text-center title-2">Edit</h3>
                    </div>
                    <hr>
                    <form action="{{ route('admin.mentors.edit',$mentor->id) }}" method="post" novalidate="novalidate">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="fullname" class="control-label mb-1">Nama Lengkap</label>
                            <input id="fullname" name="fullname" type="text" class="form-control" aria-required="true" aria-invalid="false" required value="{{ $mentor->fullname }}">
                        </div>
                        <div class="form-group has-success">
                            <label for="email" class="control-label mb-1">Email</label>
                            <input id="email" name="email" type="email" class="form-control" aria-required="true" aria-invalid="false" required value="{{ $mentor->email }}">
                        </div>
                        <div class="form-group has-success">
                            <label for="password" class="control-label mb-1">Password</label>
                            <input id="password" name="password" type="password" class="form-control" aria-required="true" aria-invalid="false" required placeholder="Jangan Diisi Kalau Tidak Mau Diubah" autocomplete="new-password">
                        </div>
                        <div class="form-group has-success">
                            <label for="position" class="control-label mb-1">Position</label>
                            <select name="position" id="position" class="form-control"> 
                                @forelse ($positions as $position)
                                    <option value="{{ $position->id }}" {{ $position->id == $mentor->id_role ? 'selected' : '' }}>{{ $position->name }}</option></option>
                                @empty
                                    
                                @endforelse
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-lg btn-info btn-block">
                                <span>Submit</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
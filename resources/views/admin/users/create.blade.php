@extends('admin.layout.layout')
@section('judul')
    Student
@endsection
@section('content')
    <div>
        <div class="mt-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3 class="text-center title-2">Create</h3>
                    </div>
                    <hr>
                    <form action="{{ route('admin.users.store') }}" method="post" novalidate="novalidate">
                        @csrf
                        <div class="form-group">
                            <label for="fullname" class="control-label mb-1">Nama Lengkap</label>
                            <input id="fullname" name="fullname" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                        </div>
                        <div class="form-group has-success">
                            <label for="email" class="control-label mb-1">Email</label>
                            <input id="email" name="email" type="email" class="form-control" aria-required="true" aria-invalid="false" required>
                        </div>
                        <div class="form-group has-success">
                            <label for="phone_number" class="control-label mb-1">No HP</label>
                            <input id="phone_number" name="phone_number" type="text" class="form-control" aria-required="true" aria-invalid="false" autocomplete="off" required>
                        </div>
                        <div class="form-group has-success">
                            <label for="asal_sekolah" class="control-label mb-1">Asal Sekolah</label>
                            <input id="asal_sekolah" name="asal_sekolah" type="text" class="form-control" aria-required="true" aria-invalid="false" autocomplete="off" required>
                        </div>
                        <div class="form-group has-success">
                            <label for="instructor" class="control-label mb-1">Instructor</label>
                            <select name="instructor" id="instructor" class="form-control" aria-required="true" aria-invalid="false">
                                <option value="" selected disabled>--Pilih--</option>
                                @forelse ($instructors as $instructor)
                                    <option value="{{ $instructor->id }}">{{ $instructor->fullname }}</option>
                                @empty
                                    
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group has-success">
                            <label for="mulai_magang" class="control-label mb-1">Tanggal Mulai Magang</label>
                            <input id="mulai_magang" name="mulai_magang" type="text" class="form-control date" aria-required="true" aria-invalid="false" autocomplete="off" placeholder="dd/mm/yyyy" required>
                        </div>
                        <div class="form-group has-success">
                            <label for="selesai_magang" class="control-label mb-1">Tanggal Selesai Magang</label>
                            <input id="selesai_magang" name="selesai_magang" type="text" class="form-control date" aria-required="true" aria-invalid="false" autocomplete="off" placeholder="dd/mm/yyyy" required>
                        </div>
                        <div class="form-group has-success">
                            <label for="flag" class="control-label mb-1">Flag</label>
                            <select name="flag" id="flag" class="form-control" aria-required="true" aria-invalid="false">
                                <option value="" selected disabled>--Pilih--</option>
                                <option value="0">Deactive</option>
                                <option value="1">Active</option>
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
@section('script')
    <script>
        $('.date').datepicker({
            format: 'dd/mm/yyyy',
            autoHide: true
        });
        $('.date').mask('00/00/0000');
        $('#phone_number').mask('0000-0000-0000-0000');
        $(function(){
            var schools = [
            "{!! $schools !!}"
            ];
            $('#asal_sekolah').autocomplete({
                source: schools
            });
        });
    </script>
@endsection
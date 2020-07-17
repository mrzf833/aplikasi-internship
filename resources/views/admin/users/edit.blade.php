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
                        <h3 class="text-center title-2">Edit</h3>
                    </div>
                    <hr>
                    <form action="{{ route('admin.users.edit',$student->id) }}" method="post" novalidate="novalidate">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="fullname" class="control-label mb-1">Nama Lengkap</label>
                            <input id="fullname" name="fullname" type="text" class="form-control" aria-required="true" aria-invalid="false" required value="{{ $student->fullname }}">
                        </div>
                        <div class="form-group has-success">
                            <label for="email" class="control-label mb-1">Email</label>
                            <input id="email" name="email" type="email" class="form-control" aria-required="true" aria-invalid="false" required value="{{ $student->email }}">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label mb-1">Password</label>
                            <input id="password" name="password" type="password" class="form-control" aria-required="true" aria-invalid="false" autocomplete="new-password" required placeholder="Jangan Diisi Kalau Tidak Mau Di Ganti">
                        </div>
                        <div class="form-group has-success">
                            <label for="phone_number" class="control-label mb-1">No HP</label>
                            <input id="phone_number" name="phone_number" type="text" class="form-control" aria-required="true" aria-invalid="false" autocomplete="off" required value="{{ $student->user_profiles()->first()->phone_number }}">
                        </div>
                        <div class="form-group has-success">
                            <label for="asal_sekolah" class="control-label mb-1">Asal Sekolah</label>
                            <input id="asal_sekolah" name="asal_sekolah" type="text" class="form-control" aria-required="true" aria-invalid="false" autocomplete="off" required value="{{ $student->user_profiles()->first()->schools()->first()->name }}">
                        </div>
                        <div class="form-group has-success">
                            <label for="instructor" class="control-label mb-1">Instructor</label>
                            <select name="instructor" id="instructor" class="form-control" aria-required="true" aria-invalid="false">
                                @forelse ($instructors as $instructor)
                                    <option value="{{ $instructor->id }}" {{ $instructor->id === $student->user_profiles()->first()->id_instructor ? 'selected' : '' }}>{{ $instructor->fullname }}</option>
                                @empty
                                    
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group has-success">
                            <label for="mulai_magang" class="control-label mb-1">Tanggal Mulai Magang</label>
                            <input id="mulai_magang" name="mulai_magang" type="text" class="form-control date" aria-required="true" aria-invalid="false" autocomplete="off" placeholder="dd/mm/yyyy" required value="{{ $student->user_profiles()->first()->start_internship->format('d/m/Y') }}">
                        </div>
                        <div class="form-group has-success">
                            <label for="selesai_magang" class="control-label mb-1">Tanggal Selesai Magang</label>
                            <input id="selesai_magang" name="selesai_magang" type="text" class="form-control date" aria-required="true" aria-invalid="false" autocomplete="off" placeholder="dd/mm/yyyy" required value="{{ $student->user_profiles()->first()->end_internship->format('d/m/Y') }}">
                        </div>
                        <div class="form-group has-success">
                            <label for="flag" class="control-label mb-1">Flag</label>
                            <select name="flag" id="flag" class="form-control" aria-required="true" aria-invalid="false">
                                <option value="0" {{ $student->flag == '0' ? 'selected' : '' }}>Deactive</option>
                                <option value="1" {{ $student->flag == '1' ? 'selected' : '' }}>Active</option>
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
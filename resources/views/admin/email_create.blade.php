@component('mail::message')
    # Selamat Anda Telah Terdaftar Di Aplikasi Internship
    Silahkan Login Dengan Data-Data Anda :

    nama        : {{ $fullname }}
    email       : {{ $email }}
    password    : {{ $password }}

    Terimakasih Telah Menggunakan Aplikasi Internship.
    Jika ada kendala atau masalah silahkan langsung ke blablabla.
@endcomponent
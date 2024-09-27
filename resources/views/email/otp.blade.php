<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kode OTP - Verifikasi CUSTicket</title>
</head>

@php
    $setting = \App\Models\Setting::first();
@endphp

<body style="color: #252a61; text-align: center; background-color: darkblue; font-family: 'Poppins', sans-serif; padding: 2rem 1rem;">
    <div style="max-width: 480px; margin: 0 auto">
        <div style="border-top: 8px solid #252a61; background-color: #fff; padding: 2rem 1.5rem; border-radius: 0.5rem;">
            <h1>
                <img src="{{ asset($setting->logo) }}" width="200" alt="Logo CUSTicket">
            </h1>
            <div>
                <h2 style="font-weight: 500">Selamat Datang di CUSTicket, {{ $nama }}!</h2>
                <p>Untuk memastikan ini adalah Anda yang mendaftar, berikut adalah <strong>Kode OTP</strong> untuk verifikasi pendaftaran
                    Anda:</p>
                <div style="padding: 0.75rem 1.5rem; background-color: lightcyan; border-radius: 0.5rem; display: inline-block; margin: 1.25rem 0; overflow: hidden;">
                    <h1 style="letter-spacing: 5px; margin: 0">{{ $otp }}</h1>
                </div>
                <p>
                    Kode OTP ini akan kadaluarsa dalam waktu <strong>2 menit</strong>.
                </p>
                <p>
                    <small>Jika Anda tidak mendaftar di CUSTicket, abaikan email ini.</small>
                </p>
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <div>
                <small>{{ date('Y') }} ©</small>
                <small>{{ $setting->app }}</small>
            </div>
            <div>
                <small>{{ $setting->description }}</small>
            </div>
        </div>
    </div>
</body>

</html>

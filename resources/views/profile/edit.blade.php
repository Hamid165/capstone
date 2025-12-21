@extends('layouts.app')

@section('title', 'Profil Saya - Dhawuh Bumi')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-6 max-w-4xl">
        {{-- Header --}}
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-bold text-slate-800 font-serif mb-2">Pengaturan Profil</h1>
            <p class="text-gray-500">Kelola informasi akun dan keamanan Anda.</p>
        </div>

        <div class="space-y-8">
            {{-- Update Profile --}}
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <div class="max-w-xl">
                    <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-user-circle text-[#4CAF50]"></i> Informasi Profil
                    </h2>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password --}}
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <div class="max-w-xl">
                    <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-lock text-[#4CAF50]"></i> Ganti Password
                    </h2>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="bg-red-50 rounded-3xl p-8 shadow-sm border border-red-100">
                <div class="max-w-xl">
                    <h2 class="text-xl font-bold text-red-700 mb-4 flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle"></i> Hapus Akun
                    </h2>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

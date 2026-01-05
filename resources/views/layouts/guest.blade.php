<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="icon" href="{{ asset('assets/tablogo.svg') }}" type="image/svg+xml">
        <title>{{ config('app.name', 'Dhawuh Bumi') }}</title>

        <!-- Tailwind CSS (CDN for Immediate Styling) -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            emerald: {
                                50: '#ecfdf5',
                                100: '#d1fae5',
                                200: '#a7f3d0',
                                300: '#6ee7b7',
                                400: '#34d399',
                                500: '#10b981',
                                600: '#059669',
                                700: '#047857',
                                800: '#065f46',
                                900: '#064e3b',
                            }
                        },
                        fontFamily: {
                            sans: ['Plus Jakarta Sans', 'sans-serif'],
                            serif: ['Playfair Display', 'serif'],
                        }
                    }
                }
            }
        </script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased selection:bg-emerald-500 selection:text-white">
        <div class="min-h-screen flex bg-white">
            <!-- Left Side: Form -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 sm:px-12 lg:px-24 py-12 relative">
                <!-- Mobile Background Decoration -->
                <div class="absolute top-0 left-0 w-full h-2 bg-emerald-500 lg:hidden"></div>

                <div class="w-full max-w-md mx-auto">
                    <!-- Logo -->
                    <div class="mb-3 text-center lg:text-left">
                        <a href="/" class="inline-flex items-center gap-3 group">
                            <img src="{{ asset('assets/logo.png') }}" class="h-12 w-auto group-hover:scale-105 transition-transform" alt="Logo">
                            <span class="text-2xl font-bold text-[#2E4F38] tracking-tight">Dhawuh Bumi</span>
                        </a>
                    </div>

                    <!-- Slot (Form) -->
                    <div class="bg-white">
                        {{ $slot }}
                    </div>

                    <!-- Footer Links -->
                    <div class="mt-8 text-center text-xs text-gray-400">
                        &copy; {{ date('Y') }} Dhawuh Bumi. All rights reserved.
                    </div>
                </div>
            </div>

            <!-- Right Side: Image -->
            <div class="hidden lg:block w-1/2 bg-cover bg-center relative" style="background-image: url('{{ asset('assets/dawuhbumi3.jpg') }}');">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-16 text-white max-w-xl">
                    <div class="w-16 h-1 bg-emerald-500 mb-6"></div>
                    <h2 class="text-4xl font-serif font-bold mb-4 leading-tight">Kesegaran Alami Langsung dari Kebun</h2>
                    <p class="text-lg text-white font-light leading-relaxed">
                        Nikmati sayuran hidroponik berkualitas premium yang dirawat dengan teknologi modern untuk kesehatan keluarga Anda.
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>

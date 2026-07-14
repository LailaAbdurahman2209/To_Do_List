<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full antialiased">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background-color: #fafafa; /* Crisp, clean off-white */
            }
            /* Make Jetstream cards look premium (No heavy dark shadows, just clean micro-borders) */
            .bg-white {
                border: 1px solid rgba(226, 232, 240, 0.8) !important;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02), 0 1px 2px -1px rgba(0, 0, 0, 0.02) !important;
                border-radius: 12px !important;
            }
            /* Smooth focus rings for all inputs */
            input, select, textarea {
                border-radius: 8px !important;
                border-color: #e2e8f0 !important;
                transition: all 0.2s ease-in-out !important;
            }
            input:focus, select:focus, textarea:focus {
                border-color: #3b82f6 !important;
                box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
            }
            /* Make buttons look sharp and clickable */
            button, .btn {
                border-radius: 8px !important;
                font-weight: 500 !important;
                letter-spacing: -0.01em !important;
                transition: all 0.15s ease-in-out !important;
            }
        </style>
    </head>
    <body class="text-slate-900 h-full selection:bg-blue-500/10 selection:text-blue-600">
        <x-banner />

        <div class="min-h-screen flex flex-col relative overflow-hidden bg-[#fafafa]">
            
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[350px] bg-gradient-to-b from-blue-50/40 to-transparent pointer-events-none -z-10" aria-hidden="true"></div>

            <div class="border-b border-slate-200/80 bg-white/80 backdrop-blur-md sticky top-0 z-40">
                @livewire('navigation-menu')
            </div>

            @if (isset($header))
                <header class="py-8 bg-transparent">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endif

            <main class="flex-1 pb-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>

        @stack('modals')
        @livewireScripts
    </body>
</html>
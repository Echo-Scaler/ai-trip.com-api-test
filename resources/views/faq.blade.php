@extends('layouts.app')

@section('title', __('messages.faq') . ' — TripExplorer')

@section('content')
<div class="relative min-h-screen py-20 px-4 sm:px-6 lg:px-8">
    <!-- Animated background elements -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary-600/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-accent-600/10 rounded-full blur-[120px]"></div>
    </div>

    <div class="max-w-4xl mx-auto relative z-10">
        <!-- Header -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary-500/10 border border-primary-500/20 text-primary-400 text-sm font-semibold mb-6">
                <i data-lucide="help-circle" class="w-4 h-4"></i>
                {{ __('messages.faq') }}
            </div>
            <h1 class="text-4xl sm:text-5xl font-black text-white mb-6 tracking-tight">
                {{ __('messages.faq_title') }}
            </h1>
            <p class="text-xl text-gray-400 max-w-2xl mx-auto leading-relaxed">
                {{ __('messages.faq_subtitle') }}
            </p>
        </div>

        <!-- FAQ Items -->
        <div class="space-y-6">
            @php
            $faqs = [
            ['q' => 'q_what_is', 'a' => 'a_what_is', 'icon' => 'info'],
            ['q' => 'q_is_real', 'a' => 'a_is_real', 'icon' => 'shield-check'],
            ['q' => 'q_hotel_search', 'a' => 'a_hotel_search', 'icon' => 'building-2'],
            ['q' => 'q_flight_codes', 'a' => 'a_flight_codes', 'icon' => 'plane'],
            ['q' => 'q_ai_assistant', 'a' => 'a_ai_assistant', 'icon' => 'sparkles'],
            ['q' => 'q_map_interactive', 'a' => 'a_map_interactive', 'icon' => 'map-pin'],
            ];
            @endphp

            @foreach($faqs as $faq)
            <div class="glass rounded-3xl p-8 card-hover shine-effect group">
                <div class="flex gap-6">
                    <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center flex-shrink-0 transition-transform group-hover:scale-110 duration-500">
                        <i data-lucide="{{ $faq['icon'] }}" class="w-7 h-7 text-primary-400"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white mb-3">{{ __('messages.' . $faq['q']) }}</h3>
                        <p class="text-gray-400 leading-relaxed">{{ __('messages.' . $faq['a']) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Contact Section -->
        <div class="mt-20 p-10 rounded-3xl bg-gradient-to-br from-primary-600/20 to-accent-600/20 border border-white/10 text-center">
            <h2 class="text-2xl font-bold text-white mb-4">{{ __('messages.still_have_questions') }}</h2>
            <p class="text-gray-400 mb-8 max-w-xl mx-auto">{{ __('messages.contact_support') }}</p>
            <a href="javascript:void(0)" onclick="toggleChat()" class="inline-flex items-center gap-3 px-8 py-4 bg-primary-600 hover:bg-primary-500 text-white rounded-2xl font-bold transition-all transform hover:scale-105 shadow-lg shadow-primary-600/20">
                <i data-lucide="message-square" class="w-5 h-5"></i>
                {{ __('messages.start_chat') }}
            </a>
        </div>
    </div>
</div>
@endsection
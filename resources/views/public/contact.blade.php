@extends('layouts.public')

@section('title', __('public.contact.title'))

@section('content')
<main class="page">
    <header class="page-header">
        <h1>{{ __('public.contact.title') }}</h1>
        <p>{{ __('public.contact.intro') }}</p>
    </header>

    <section class="contact-layout">
        <div class="card">
            <h2>{{ __('public.contact.address_title') }}</h2>
            <p>{{ __('public.contact.address') }}</p>
            <h2 style="margin-top:22px">{{ __('public.contact.hours_title') }}</h2>
            <p>{{ __('public.contact.hours') }}</p>
            <h2 style="margin-top:22px">{{ __('public.contact.phone_title') }}</h2>
            <p>{{ __('public.contact.phone') }}</p>
            <h2 style="margin-top:22px">{{ __('public.contact.social_title') }}</h2>
            <p>{{ __('public.contact.social') }}</p>
        </div>

        <div class="card">
            <h2>{{ __('public.contact.form_title') }}</h2>
            @if(session('success'))
                <div class="alert">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('public.contact.submit') }}">
                @csrf
                <div class="form-group">
                    <label for="name">{{ __('public.contact.name') }}</label>
                    <input id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')<p style="color:#a32d2d">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label for="email">{{ __('public.contact.email') }}</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required>
                    @error('email')<p style="color:#a32d2d">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label for="message">{{ __('public.contact.message') }}</label>
                    <textarea id="message" name="message" required>{{ old('message') }}</textarea>
                    @error('message')<p style="color:#a32d2d">{{ $message }}</p>@enderror
                </div>
                <button class="btn" type="submit">{{ __('public.contact.send') }}</button>
            </form>
        </div>
    </section>
</main>
@endsection

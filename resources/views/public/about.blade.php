@extends('layouts.public')

@section('title', __('public.about.title'))

@section('content')
<main class="page">
    <header class="page-header">
        <h1>{{ __('public.about.title') }}</h1>
        <p>{{ __('public.about.intro') }}</p>
    </header>

    <section class="grid two">
        <article class="card">
            <h2>{{ __('public.about.mission_title') }}</h2>
            <p>{{ __('public.about.mission') }}</p>
        </article>
        <article class="card">
            <h2>{{ __('public.about.values_title') }}</h2>
            <ul class="list">
                @foreach(__('public.about.values') as $value)
                    <li>{{ $value }}</li>
                @endforeach
            </ul>
        </article>
    </section>

    <section style="margin-top:28px">
        <div class="page-header">
            <h1>{{ __('public.about.trainers_title') }}</h1>
        </div>
        <div class="grid">
            @foreach(__('public.about.trainers') as $trainer)
                <article class="card">
                    <h2>{{ $trainer['name'] }}</h2>
                    <h3 style="font-size:14px;color:#636059">{{ $trainer['role'] }}</h3>
                    <p>{{ $trainer['text'] }}</p>
                </article>
            @endforeach
        </div>
    </section>
</main>
@endsection

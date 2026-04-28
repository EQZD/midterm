@extends('layouts.public')

@section('title', __('public.services.title'))

@section('content')
<main class="page">
    <header class="page-header">
        <h1>{{ __('public.services.title') }}</h1>
        <p>{{ __('public.services.intro') }}</p>
    </header>

    <section class="grid two">
        @foreach(__('public.services.items') as $service)
            <article class="card">
                <h2>{{ $service['title'] }}</h2>
                <p>{{ $service['text'] }}</p>
            </article>
        @endforeach
    </section>
</main>
@endsection

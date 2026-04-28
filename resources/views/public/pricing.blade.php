@extends('layouts.public')

@section('title', __('public.pricing.title'))

@section('content')
<main class="page">
    <header class="page-header">
        <h1>{{ __('public.pricing.title') }}</h1>
        <p>{{ __('public.pricing.intro') }}</p>
    </header>

    <section class="grid">
        @foreach(__('public.pricing.plans') as $plan)
            <article class="card">
                <h2>{{ $plan['name'] }}</h2>
                <div class="price">{{ $plan['price'] }}</div>
                <p>{{ $plan['text'] }}</p>
                <ul class="list">
                    @foreach($plan['features'] as $feature)
                        <li>{{ $feature }}</li>
                    @endforeach
                </ul>
            </article>
        @endforeach
    </section>

    <section class="card" style="margin-top:20px">
        <h2>{{ __('public.pricing.discounts_title') }}</h2>
        <ul class="list">
            @foreach(__('public.pricing.discounts') as $discount)
                <li>{{ $discount }}</li>
            @endforeach
        </ul>
    </section>
</main>
@endsection

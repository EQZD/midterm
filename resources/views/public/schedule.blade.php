@extends('layouts.public')

@section('title', __('public.schedule.title'))

@section('content')
<main class="page">
    <header class="page-header">
        <h1>{{ __('public.schedule.title') }}</h1>
        <p>{{ __('public.schedule.intro') }}</p>
    </header>

    @foreach(__('public.schedule.days') as $day)
        <section class="schedule-day">
            <h2>{{ $day['day'] }}</h2>
            <table>
                <thead>
                    <tr>
                        <th>{{ __('public.schedule.time') }}</th>
                        <th>{{ __('public.schedule.class') }}</th>
                        <th>{{ __('public.schedule.trainer') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($day['classes'] as $class)
                        <tr>
                            <td>{{ $class[0] }}</td>
                            <td>{{ $class[1] }}</td>
                            <td>{{ $class[2] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    @endforeach
</main>
@endsection

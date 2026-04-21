@extends('layouts.dashboard')

@section('title', 'My Membership')
@section('role-label', 'Member')
@php $badgeBg = '#faeeda'; $badgeColor = '#412402'; @endphp

@section('nav')
    <span class="nav-section">My Account</span>
    <a href="{{ route('member.profile') }}" class="nav-link active">
        <span class="nav-icon">◉</span> My Profile
    </a>
@endsection

@section('content')
<div class="page-header">
    <h1>My Membership</h1>
    <p>Your current membership details.</p>
</div>

@if($member ?? null)

{{-- Profile card --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px">
    <div class="card" style="margin:0">
        <div class="card-header"><h2>Personal Info</h2></div>
        <div class="card-body">
            <div style="display:flex;align-items:center;gap:16px;margin-bottom:20px">
                <div style="width:52px;height:52px;border-radius:50%;background:#1a1917;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:500;color:#f5f4f0;font-family:'DM Mono',monospace">
                    {{ strtoupper(substr($member->name, 0, 1)) }}
                </div>
                <div>
                    <div style="font-size:16px;font-weight:500">{{ $member->name }}</div>
                    <div style="font-size:13px;color:var(--muted)">{{ $member->email }}</div>
                </div>
            </div>
            <table style="width:100%;font-size:13px">
                <tr>
                    <td style="color:var(--muted);padding:6px 0;width:40%">Phone</td>
                    <td style="padding:6px 0">{{ $member->phone ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="color:var(--muted);padding:6px 0">Member since</td>
                    <td style="padding:6px 0;font-family:'DM Mono',monospace;font-size:12px">
                        {{ \Carbon\Carbon::parse($member->join_date)->format('d F Y') }}
                    </td>
                </tr>
                <tr>
                    <td style="color:var(--muted);padding:6px 0">Duration</td>
                    <td style="padding:6px 0">
                        {{ \Carbon\Carbon::parse($member->join_date)->diffForHumans(null, true) }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="card" style="margin:0">
        <div class="card-header"><h2>Membership Type</h2></div>
        <div class="card-body">
            @php
                $type = $member->membership_type;
                $config = match($type) {
                    'Gold'   => ['bg' => '#faeeda', 'color' => '#633806', 'desc' => 'Full access to all facilities, priority booking, and exclusive events.'],
                    'Silver' => ['bg' => '#f1efe8', 'color' => '#2c2c2a', 'desc' => 'Access to main facilities and standard class booking.'],
                    default  => ['bg' => '#faece7', 'color' => '#4a1b0c', 'desc' => 'Access to basic facilities during standard hours.'],
                };
            @endphp

            <div style="text-align:center;padding:20px 0">
                <div style="display:inline-block;padding:8px 24px;border-radius:30px;font-size:20px;font-weight:500;font-family:'DM Mono',monospace;background:{{ $config['bg'] }};color:{{ $config['color'] }}">
                    {{ $type }}
                </div>
                <p style="margin-top:16px;font-size:13px;color:var(--muted);line-height:1.6">
                    {{ $config['desc'] }}
                </p>
            </div>

            <div style="border-top:1px solid var(--border);padding-top:14px;margin-top:4px">
                <div style="font-size:11px;text-transform:uppercase;letter-spacing:0.8px;color:var(--muted);margin-bottom:8px;font-weight:500">Included</div>
                @if($type === 'Gold')
                    <div style="font-size:13px;line-height:2">✓ All facilities &nbsp; ✓ Priority booking<br>✓ Exclusive events &nbsp; ✓ Guest passes</div>
                @elseif($type === 'Silver')
                    <div style="font-size:13px;line-height:2">✓ Main facilities &nbsp; ✓ Class booking<br>✓ Locker access</div>
                @else
                    <div style="font-size:13px;line-height:2">✓ Basic facilities &nbsp; ✓ Standard hours</div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="alert alert-warning">
    To change your membership type or update contact details, please speak to a staff member at reception.
</div>

@else
    <div class="alert alert-info">No membership profile found linked to your account. Please contact reception.</div>
@endif
@endsection

@extends('layouts.dashboard')

@section('title', $member->name)
@section('role-label', ucfirst(Auth::user()->roles->first()?->name ?? 'user'))

@section('nav')
    <span class="nav-section">{{ __('messages.members') }}</span>
    <a href="{{ route('members.index') }}" class="nav-link">
        <span class="nav-icon">◉</span> {{ __('messages.all_members') }}
    </a>
    <a href="{{ route('members.create') }}" class="nav-link">
        <span class="nav-icon">+</span> {{ __('messages.add_member') }}
    </a>
@endsection

@section('content')

<div class="page-header" style="display:flex;align-items:center;justify-content:space-between">
    <div>
        <h1>{{ $member->name }}</h1>
        <p>{{ __('messages.member_profile_documents') }}</p>
    </div>
    @can('update', $member)
    @endcan
    @if(Auth::user()->hasAnyRole(['super_admin','manager']))
        <a href="{{ route('members.edit', $member) }}" class="btn">{{ __('messages.edit_member') }}</a>
    @endif
</div>

{{-- Member info --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px">
    <div class="card" style="margin:0">
        <div class="card-header"><h2>{{ __('messages.personal_info') }}</h2></div>
        <div class="card-body">
            <table style="width:100%;font-size:13px">
                <tr>
                    <td style="color:var(--muted);padding:7px 0;width:35%">{{ __('messages.name') }}</td>
                    <td style="padding:7px 0;font-weight:500">{{ $member->name }}</td>
                </tr>
                <tr>
                    <td style="color:var(--muted);padding:7px 0">{{ __('messages.email') }}</td>
                    <td style="padding:7px 0">{{ $member->email }}</td>
                </tr>
                <tr>
                    <td style="color:var(--muted);padding:7px 0">{{ __('messages.phone') }}</td>
                    <td style="padding:7px 0">{{ $member->phone ?? '—' }}</td>
                </tr>
                <tr>
                    <td style="color:var(--muted);padding:7px 0">{{ __('messages.type') }}</td>
                    <td style="padding:7px 0">
                        <span class="badge {{ $member->membership_type === 'Gold' ? 'badge-gold' : ($member->membership_type === 'Silver' ? 'badge-silver' : 'badge-bronze') }}">
                            {{ $member->membership_type }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="color:var(--muted);padding:7px 0">{{ __('messages.joined') }}</td>
                    <td style="padding:7px 0;font-family:'DM Mono',monospace;font-size:12px">
                        {{ \Carbon\Carbon::parse($member->join_date)->format('d F Y') }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Upload new file --}}
    @if(Auth::user()->hasAnyRole(['super_admin','manager','staff']))
    <div class="card" style="margin:0">
        <div class="card-header"><h2>{{ __('messages.upload_document') }}</h2></div>
        <div class="card-body">
            <form method="POST"
                  action="{{ route('files.store', $member) }}"
                  enctype="multipart/form-data">
                @csrf

                <div style="border:2px dashed var(--border);border-radius:8px;padding:24px;text-align:center;cursor:pointer;transition:border-color 0.2s"
                     id="dropzone"
                     onclick="document.getElementById('fileInput').click()">
                    <div style="font-size:24px;margin-bottom:8px">↑</div>
                    <div style="font-size:13px;font-weight:500">{{ __('messages.click_to_select_file') }}</div>
                    <div style="font-size:12px;color:var(--muted);margin-top:4px" id="fileName">
                        JPG, PNG, PDF, DOC — max 10MB
                    </div>
                </div>

                <input type="file"
                       id="fileInput"
                       name="file"
                       style="display:none"
                       accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                       onchange="document.getElementById('fileName').textContent = this.files[0]?.name ?? '{{ __('messages.no_file_chosen') }}'">

                @error('file')
                    <p style="color:#a32d2d;font-size:12px;margin-top:8px">{{ $message }}</p>
                @enderror

                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:12px">
                    {{ __('messages.upload_file') }}
                </button>
            </form>
        </div>
    </div>
    @endif
</div>

{{-- Files list --}}
<div class="card">
    <div class="card-header">
        <h2>{{ __('messages.documents') }} ({{ $member->files->count() }})</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>{{ __('messages.file_name') }}</th>
                <th>{{ __('messages.type') }}</th>
                <th>{{ __('messages.size') }}</th>
                <th>{{ __('messages.uploaded_by') }}</th>
                <th>{{ __('messages.date') }}</th>
                <th>{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody>
        @forelse($member->files as $file)
            <tr>
                <td style="font-weight:500">{{ $file->original_name }}</td>
                <td style="color:var(--muted);font-size:12px;font-family:'DM Mono',monospace">
                    {{ $file->mime_type }}
                </td>
                <td style="color:var(--muted)">{{ $file->human_size }}</td>
                <td style="color:var(--muted)">{{ $file->uploaded_by }}</td>
                <td style="color:var(--muted);font-family:'DM Mono',monospace;font-size:12px">
                    {{ $file->created_at->format('d M Y') }}
                </td>
                <td style="display:flex;gap:6px;align-items:center">
                    <a href="{{ route('files.download', $file) }}" class="btn btn-sm">↓ {{ __('messages.download') }}</a>

                    @if(Auth::user()->hasAnyRole(['super_admin','manager']))
                    <form method="POST" action="{{ route('files.destroy', $file) }}"
                          onsubmit="return confirm('{{ __('messages.confirm_delete_file') }}')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm" style="color:#a32d2d;border-color:#f7c1c1">{{ __('messages.delete') }}</button>
                    </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align:center;color:var(--muted);padding:32px">
                    {{ __('messages.no_documents_uploaded') }}
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

@endsection

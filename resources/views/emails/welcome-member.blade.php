<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to MemberHub</title>
</head>
<body style="margin:0;padding:0;background:#f5f4f0;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f4f0;padding:40px 20px">
    <tr>
        <td align="center">
            <table width="560" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #e2e0d8">

                {{-- Header --}}
                <tr>
                    <td style="background:#1a1917;padding:32px 40px">
                        <p style="margin:0;font-family:'Courier New',monospace;font-size:18px;font-weight:600;color:#f5f4f0;letter-spacing:-0.5px">
                            MemberHub
                        </p>
                        <p style="margin:6px 0 0;font-size:12px;color:#888580;letter-spacing:1px;text-transform:uppercase">
                            Fitness Club
                        </p>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="padding:40px 40px 32px">
                        <p style="margin:0 0 24px;font-size:26px;font-weight:300;color:#1a1917;letter-spacing:-0.5px;line-height:1.3">
                            Welcome,<br><strong style="font-weight:500">{{ $member->name }}</strong>.
                        </p>

                        <p style="margin:0 0 20px;font-size:15px;color:#5a5855;line-height:1.7">
                            Your membership has been successfully registered. We're glad to have you as part of the club.
                        </p>

                        {{-- Membership card --}}
                        <table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f4f0;border-radius:8px;margin:24px 0;border:1px solid #e2e0d8">
                            <tr>
                                <td style="padding:20px 24px">
                                    <p style="margin:0 0 14px;font-size:10px;text-transform:uppercase;letter-spacing:1px;color:#7a7870;font-weight:600">
                                        Your Membership Details
                                    </p>
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;color:#7a7870;width:40%">Name</td>
                                            <td style="padding:6px 0;font-size:13px;color:#1a1917;font-weight:500">{{ $member->name }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;color:#7a7870">Email</td>
                                            <td style="padding:6px 0;font-size:13px;color:#1a1917">{{ $member->email }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;color:#7a7870">Phone</td>
                                            <td style="padding:6px 0;font-size:13px;color:#1a1917">{{ $member->phone ?? '—' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;color:#7a7870">Membership</td>
                                            <td style="padding:6px 0">
                                                @php
                                                    $colors = [
                                                        'Gold'   => ['bg'=>'#faeeda','color'=>'#633806'],
                                                        'Silver' => ['bg'=>'#f1efe8','color'=>'#2c2c2a'],
                                                        'Bronze' => ['bg'=>'#faece7','color'=>'#4a1b0c'],
                                                    ];
                                                    $c = $colors[$member->membership_type] ?? $colors['Bronze'];
                                                @endphp
                                                <span style="display:inline-block;padding:2px 10px;border-radius:20px;font-size:12px;font-weight:600;background:{{ $c['bg'] }};color:{{ $c['color'] }}">
                                                    {{ $member->membership_type }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:6px 0;font-size:13px;color:#7a7870">Member since</td>
                                            <td style="padding:6px 0;font-size:13px;color:#1a1917;font-family:'Courier New',monospace">
                                                {{ \Carbon\Carbon::parse($member->join_date)->format('d F Y') }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <p style="margin:0;font-size:14px;color:#5a5855;line-height:1.7">
                            If you have any questions, please contact us at reception or reply to this email.
                        </p>
                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td style="padding:20px 40px;border-top:1px solid #e2e0d8;background:#faf9f6">
                        <p style="margin:0;font-size:12px;color:#7a7870">
                            © {{ date('Y') }} MemberHub Fitness Club. This email was sent automatically.
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>

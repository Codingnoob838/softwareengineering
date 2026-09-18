<?php

namespace App\Http\Controllers;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $activeTab = $request->string('tab')->toString();
        $activeTab = in_array($activeTab, ['overview', 'membership', 'check-ins', 'qr-pass'], true)
            ? $activeTab
            : 'overview';

        $member = $request->user()->load([
            'memberships' => fn ($query) => $query->latest(),
            'attendanceRecords' => fn ($query) => $query->latest('checked_in_at')->limit(5),
        ]);

        return view('member.dashboard', [
            'member' => $member,
            'membership' => $member->memberships->first(),
            'attendance' => $member->attendanceRecords,
            'activeTab' => $activeTab,
            'qrDataUri' => $this->memberQrCode($member),
        ]);
    }

    private function memberQrCode($member): string
    {
        return (new Builder(
            writer: new SvgWriter(),
            data: json_encode([
                'type' => 'dfitness-member',
                'member_id' => $member->id,
                'member_code' => 'MEMBER-'.str_pad((string) $member->id, 5, '0', STR_PAD_LEFT),
                'email' => $member->email,
            ], JSON_THROW_ON_ERROR),
            size: 320,
            margin: 16,
        ))->build()
            ->getDataUri();
    }
}
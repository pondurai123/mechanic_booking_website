<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $todayOrders = Booking::today()->count();
        $monthOrders = Booking::thisMonth()->count();
        $pendingOrders = Booking::pending()->count();
        $completedOrders = Booking::completed()->count();
        $cancelledOrders = Booking::cancelled()->count();

        return view('admin.dashboard', compact(
            'todayOrders',
            'monthOrders',
            'pendingOrders',
            'completedOrders',
            'cancelledOrders'
        ));
    }

    public function pendingOrders()
    {
        $bookings = Booking::pending()->latest()->paginate(20);
        return view('admin.pending-orders', compact('bookings'));
    }

    public function completedOrders()
    {
        $bookings = Booking::completed()->latest()->paginate(20);
        return view('admin.completed-orders', compact('bookings'));
    }

    public function cancelledOrders()
    {
        $bookings = Booking::cancelled()->latest()->paginate(20);
        return view('admin.cancelled-orders', compact('bookings'));
    }

    public function settings()
    {
        $adminEmail = Setting::get('admin_email', '');
        $adminContact = Setting::get('admin_contact', '');
        $smtpHost = Setting::get('smtp_host', '');
        $smtpPort = Setting::get('smtp_port', '');
        $smtpUsername = Setting::get('smtp_username', '');
        $smtpPassword = Setting::get('smtp_password', '');

        return view('admin.settings', compact(
            'adminEmail',
            'adminContact',
            'smtpHost',
            'smtpPort',
            'smtpUsername',
            'smtpPassword'
        ));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'admin_email' => 'required|email',
            'admin_contact' => 'required|string',
            'smtp_host' => 'required|string',
            'smtp_port' => 'required|numeric',
            'smtp_username' => 'required|string',
            'smtp_password' => 'required|string'
        ]);

        Setting::set('admin_email', $request->admin_email);
        Setting::set('admin_contact', $request->admin_contact);
        Setting::set('smtp_host', $request->smtp_host);
        Setting::set('smtp_port', $request->smtp_port);
        Setting::set('smtp_username', $request->smtp_username);
        Setting::set('smtp_password', $request->smtp_password);

        // Update mail configuration
        config([
            'mail.mailers.smtp.host' => $request->smtp_host,
            'mail.mailers.smtp.port' => $request->smtp_port,
            'mail.mailers.smtp.username' => $request->smtp_username,
            'mail.mailers.smtp.password' => $request->smtp_password,
        ]);

        return back()->with('success', 'Settings updated successfully!');
    }
}
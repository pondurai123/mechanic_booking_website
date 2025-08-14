<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation;
use App\Mail\BookingApproved;
use App\Models\Mechanic;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'location' => 'nullable|string',
            'service' => 'nullable|string',
            'preferred_date' => 'nullable|date'
        ]);

        $booking = Booking::create($request->all());

        // Send confirmation email to admin
        // $adminEmail = Setting::get('admin_email', 'admin@acrepair.com');
        $adminEmail = env('MAIL_FROM_ADDRESS', 'admin@acrepair.com');

        try {
            Mail::to($adminEmail)->send(new BookingConfirmation($booking));
        } catch (\Exception $e) {
            // Log error but don't fail the booking
            \Log::error('Failed to send booking confirmation email: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Booking submitted successfully!',
            'booking_id' => $booking->id
        ]);
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'mechanic_id' => 'required|exists:mechanics,id',
            'status' => 'required|in:approved'
        ]);

        $booking = Booking::findOrFail($id);
        $mechanic = Mechanic::findOrFail($request->mechanic_id);

        $booking->update([
            'status' => 'approved',
            'mechanic_id' => $mechanic->id
        ]);

        // Send approval email to customer
        try {
            Mail::to($booking->email)->send(new BookingApproved($booking, $mechanic));
        } catch (\Exception $e) {
            \Log::error('Failed to send booking approval email: ' . $e->getMessage());
        }

        return redirect()->route('admin.pending')
                        ->with('success', 'Booking approved and mechanic assigned!');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,completed,cancelled'
        ]);

        $booking = Booking::findOrFail($id);
        $oldStatus = $booking->status;
        $booking->update(['status' => $request->status]);

        $statusMessages = [
            'pending' => 'Booking status changed to pending',
            'approved' => 'Booking approved successfully',
            'completed' => 'Booking marked as completed',
            'cancelled' => 'Booking cancelled successfully'
        ];

        $message = $statusMessages[$request->status] ?? 'Booking status updated successfully!';

        // Send email notification if status changed to approved
        if ($request->status === 'approved' && $oldStatus !== 'approved') {
            $adminContact = Setting::get('admin_contact', '+91 98765 43210');
            try {
                Mail::to($booking->email)->send(new BookingApproved($booking, $adminContact));
                $message .= ' and customer notified!';
            } catch (\Exception $e) {
                \Log::error('Failed to send status update email: ' . $e->getMessage());
            }
        }

        return back()->with('success', $message);
    }

    /**
     * Get booking details for modal display
     */
    public function getDetails($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'booking' => [
                    'id' => $booking->id,
                    'name' => $booking->name,
                    'email' => $booking->email,
                    'phone' => $booking->phone,
                    'address' => $booking->address,
                    'location' => $booking->location,
                    'service' => $booking->service,
                    'preferred_date' => $booking->preferred_date ? $booking->preferred_date->format('M d, Y') : null,
                    'status' => $booking->status,
                    'created_at' => $booking->created_at->toISOString(),
                    'updated_at' => $booking->updated_at->toISOString(),
                    'created_at_formatted' => $booking->created_at->format('M d, Y \a\t H:i A'),
                    'updated_at_formatted' => $booking->updated_at->format('M d, Y \a\t H:i A'),
                    'time_ago' => $booking->created_at->diffForHumans(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found or error occurred',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Bulk approve bookings
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'booking_ids' => 'required|array',
            'booking_ids.*' => 'exists:bookings,id'
        ]);

        $bookings = Booking::whereIn('id', $request->booking_ids)
                          ->where('status', 'pending')
                          ->get();

        $successCount = 0;
        $adminContact = Setting::get('admin_contact', '+91 98765 43210');

        foreach ($bookings as $booking) {
            try {
                $booking->update(['status' => 'approved']);
                
                // Send approval email
                Mail::to($booking->email)->send(new BookingApproved($booking, $adminContact));
                $successCount++;
            } catch (\Exception $e) {
                \Log::error("Failed to approve booking {$booking->id}: " . $e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Successfully approved {$successCount} bookings",
            'approved_count' => $successCount,
            'total_requested' => count($request->booking_ids)
        ]);
    }

    /**
     * Get booking statistics
     */
    public function getStats()
    {
        $stats = [
            'total' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'approved' => Booking::where('status', 'approved')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
            'today' => Booking::whereDate('created_at', today())->count(),
            'this_week' => Booking::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => Booking::whereMonth('created_at', now()->month)
                                  ->whereYear('created_at', now()->year)
                                  ->count(),
            'with_location' => Booking::whereNotNull('location')->where('location', '!=', '')->count(),
            'with_preferred_date' => Booking::whereNotNull('preferred_date')->count(),
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * Search bookings
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $status = $request->get('status', 'all');
        
        $bookings = Booking::query();

        if (!empty($query)) {
            $bookings->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%")
                  ->orWhere('phone', 'LIKE', "%{$query}%")
                  ->orWhere('address', 'LIKE', "%{$query}%")
                  ->orWhere('location', 'LIKE', "%{$query}%")
                  ->orWhere('service', 'LIKE', "%{$query}%");
            });
        }

        if ($status !== 'all') {
            $bookings->where('status', $status);
        }

        $results = $bookings->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'bookings' => $results->items(),
            'pagination' => [
                'current_page' => $results->currentPage(),
                'last_page' => $results->lastPage(),
                'per_page' => $results->perPage(),
                'total' => $results->total(),
            ]
        ]);
    }

    /**
     * Export bookings to CSV
     */
    public function export(Request $request)
    {
        $status = $request->get('status', 'all');
        $date_from = $request->get('date_from');
        $date_to = $request->get('date_to');

        $bookings = Booking::query();

        if ($status !== 'all') {
            $bookings->where('status', $status);
        }

        if ($date_from) {
            $bookings->whereDate('created_at', '>=', $date_from);
        }

        if ($date_to) {
            $bookings->whereDate('created_at', '<=', $date_to);
        }

        $bookings = $bookings->latest()->get();

        $filename = 'bookings_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($bookings) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'ID',
                'Name',
                'Email',
                'Phone',
                'Address',
                'Location',
                'Service',
                'Preferred Date',
                'Status',
                'Created At',
                'Updated At'
            ]);

            // Add data rows
            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->id,
                    $booking->name,
                    $booking->email,
                    $booking->phone,
                    $booking->address,
                    $booking->location,
                    $booking->service,
                    $booking->preferred_date ? $booking->preferred_date->format('Y-m-d') : '',
                    $booking->status,
                    $booking->created_at->format('Y-m-d H:i:s'),
                    $booking->updated_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

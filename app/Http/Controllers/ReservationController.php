<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    public function create()
    {
        return view('userReservation');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'guest_count' => 'required|integer|min:1|max:50',
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required|date_format:H:i',
            'service_type' => 'required|in:dinner,lunch,meeting,wedding,other',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Combine date and time
        $reservationDateTime = $request->reservation_date . ' ' . $request->reservation_time;
        
        // Check if the selected time is within business hours (10:00 AM to 10:00 PM)
        $hour = (int)date('H', strtotime($request->reservation_time));
        if ($hour < 10 || $hour >= 22) {
            return redirect()->back()
                ->withErrors(['reservation_time' => 'Reservations are only available between 10:00 AM and 10:00 PM.'])
                ->withInput();
        }

        // Create the reservation
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'guest_count' => $request->guest_count,
            'reservation_datetime' => $reservationDateTime,
            'service_type' => $request->service_type,
            'special_requests' => $request->special_requests,
            'status' => 'pending',
        ]);

        return redirect()->back()
            ->with('success', 'Your reservation has been submitted successfully! We will contact you shortly to confirm.');
    }

    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())
            ->orderBy('reservation_datetime', 'desc')
            ->paginate(10);

        return view('userReservations', compact('reservations'));
    }

    public function adminIndex()
    {
        $reservations = Reservation::latest()->paginate(10);
        return view('admin.reservationItems', compact('reservations'));
    }

    // Update reservation status (admin & user)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'admin_notes' => 'nullable|string|max:1000'
        ]);
        $reservation = \App\Models\Reservation::findOrFail($id);
        $reservation->status = $request->status;
        if ($request->has('admin_notes')) {
            $reservation->admin_notes = $request->admin_notes;
        }
        $reservation->save();
        // Jika AJAX
        if ($request->ajax()) {
            return response()->json(['success' => true, 'status' => $reservation->status]);
        }
        // Jika form biasa
        return redirect()->back()->with('success', 'Reservation status updated successfully.');
    }

    public function destroy($id)
    {
        $reservation = \App\Models\Reservation::findOrFail($id);
        $reservation->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->back()->with('success', 'Reservation deleted successfully.');
    }

    // Admin: List all reservations
    public function adminReservationList()
    {
        $reservations = \App\Models\Reservation::orderByDesc('created_at')->get();
        return view('reservationItems', compact('reservations'));
    }

    // Admin: Get reservation detail (for modal)
    public function show($id)
    {
        $reservation = \App\Models\Reservation::findOrFail($id);
        return response()->json($reservation);
    }
} 
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

        $reservationDateTime = $request->reservation_date . ' ' . $request->reservation_time;
        $hour = (int)date('H', strtotime($request->reservation_time));
        if ($hour < 10 || $hour >= 22) {
            return redirect()->back()
                ->withErrors(['reservation_time' => 'Reservations are only available between 10:00 AM and 10:00 PM.'])
                ->withInput();
        }

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

        return redirect()->route('contactus')
            ->with('success', 'Your reservation has been submitted successfully! You can now contact us via WhatsApp to confirm your reservation.');
    }

    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())
            ->orderBy('reservation_datetime', 'desc')
            ->paginate(10);

        return view('userReservation', compact('reservations'));
    }

    public function adminIndex()
    {
        $reservations = Reservation::latest()->paginate(10);
        return view('reservationItems', compact('reservations')); // Ubah ke view yang lebih terorganisir
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,confirmed,cancelled,completed',
                'admin_notes' => 'nullable|string|max:1000'
            ]);

            $reservation = Reservation::findOrFail($id);
            $reservation->status = $request->status;
            $reservation->admin_notes = $request->admin_notes;
            $reservation->save();

            return response()->json([
                'success' => true,
                'status' => $reservation->status,
                'message' => 'Reservation status updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $reservation = Reservation::findOrFail($id);
            $reservation->delete();

            return response()->json([
                'success' => true,
                'message' => 'Reservation deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete reservation: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $reservation = Reservation::findOrFail($id);
            return response()->json($reservation);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch reservation: ' . $e->getMessage()
            ], 404);
        }
    }
}
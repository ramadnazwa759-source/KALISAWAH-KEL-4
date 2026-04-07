<?php

namespace App\Http\Controllers;

use App\Models\BookingFasilitas;
use App\Models\Booking;
use App\Models\Fasilitas;
use Illuminate\Http\Request;

class BookingFasilitasController extends Controller
{
    public function index()
    {
        $data = BookingFasilitas::with('booking','fasilitas')->get();
        return view('booking_fasilitas.index', compact('data'));
    }

    public function create()
    {
        $booking = Booking::all();
        $fasilitas = Fasilitas::all();
        return view('booking_fasilitas.create', compact('booking','fasilitas'));
    }

    public function store(Request $request)
    {
        BookingFasilitas::create($request->all());
        return redirect('/booking-fasilitas');
    }

    public function edit($id)
    {
        $data = BookingFasilitas::findOrFail($id);
        return view('booking_fasilitas.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        BookingFasilitas::findOrFail($id)->update($request->all());
        return redirect('/booking-fasilitas');
    }

    public function destroy($id)
    {
        BookingFasilitas::destroy($id);
        return redirect()->back();
    }
}

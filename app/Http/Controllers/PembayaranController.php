<?php

use App\Models\Pembayaran;

class PembayaranController extends Controller
{
    public function index()
    {
        $data = Pembayaran::all();
        return view('pembayaran.index', compact('data'));
    }

    public function store(Request $request)
    {
        Pembayaran::create($request->all());
        return redirect()->back();
    }

    public function destroy($id)
    {
        Pembayaran::destroy($id);
        return redirect()->back();
    }
}

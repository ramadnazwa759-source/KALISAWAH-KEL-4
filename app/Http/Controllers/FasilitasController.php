<?php

use App\Models\Fasilitas;

class FasilitasController extends Controller
{
    public function index()
    {
        return Fasilitas::all();
    }

    public function store(Request $request)
    {
        return Fasilitas::create($request->all());
    }

    public function show($id)
    {
        return Fasilitas::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $data = Fasilitas::findOrFail($id);
        $data->update($request->all());
        return $data;
    }

    public function destroy($id)
    {
        Fasilitas::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}

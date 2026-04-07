<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use Illuminate\Http\Request;

class DiskonController extends Controller
{
    public function index()
    {
        $data = Diskon::all();
        return view('diskon.index', compact('data'));
    }

    public function create()
    {
        return view('diskon.create');
    }

    public function store(Request $request)
    {
        Diskon::create($request->all());
        return redirect('/diskon');
    }

    public function edit($id)
    {
        $data = Diskon::findOrFail($id);
        return view('diskon.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        Diskon::findOrFail($id)->update($request->all());
        return redirect('/diskon');
    }

    public function destroy($id)
    {
        Diskon::destroy($id);
        return redirect()->back();
    }
}

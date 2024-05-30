<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Mahasiswa::paginate($request->input('size', 10));
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|unique:mahasiswa|max:255',
            'hp' => 'required|numeric|min_digits:10',
            'alamat' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $mahasiswa = Mahasiswa::create([
            'nama' => $request->nama,
            'hp'   => $request->hp,
            'alamat' => $request->alamat,
        ]);
        return response()->json([
            'pesan' => 'Berhasil menambah Mahasiswa',
            'mahasiswa' => $mahasiswa
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Mahasiswa::where('id', $id)->firstOrFail();
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:mahasiswa,nama,' . $id,
            'hp' => 'required|numeric|digits:10',
            'alamat' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update($validator->validated());
        return response()->json([
                'pesan' => 'Berhasil update mahasiswa',
                'data'  => $mahasiswa,
            ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Mahasiswa::where('id', $id)->firstOrFail();
        $data->delete();
        return response()->json(['message' => 'Mahasiswa berhasil dihapus']);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use App\Http\Resources\BeritaResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::latest()->paginate(5);

        //return collection of posts as a resource
        return new BeritaResource(true, 'List Data Berita', $berita);

    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'     => 'required',
            'content'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/berita', $image->hashName());

        //insert berita
        $berita = Berita::create([
            'image'       => $image->hashName(),
            'title'       => $request->title,
            'slug'        => Str::slug($request->input('title'), '-'),
            'category_id' => $request->input('category_id'),
            'content'     => $request->content,
        ]);

        //return response
        return new BeritaResource(true, 'Berita Berhasil Ditambahkan!', $berita);
    }

    public function show($id)
    {
        $berita = Berita::findOrFail($id);

        return new BeritaResource(true, 'Data Berita Ditemukan!', $berita);
    }


    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'content'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $berita = Berita::findOrFail($id);
        //check if image is not empty
        if ($request->hasFile('image')) {

            //upload image
            $image = $request->file('image');
            $image->storeAs('public/berita', $image->hashName());

            //delete old image
            Storage::delete('public/berita/'.$berita->image);

            //update berita with new image
            $berita->update([
                'image'     => $image->hashName(),
                'title'     => $request->title,
                'slug'        => Str::slug($request->title, '-'),
                'category_id' => $request->category_id,
                'content'   => $request->content,
            ]);

        } else {

            //update berita without image
            $berita->update([
                'title'     => $request->title,
                'content'   => $request->content,
            ]);
        }

        //return response
        return new BeritaResource(true, 'Data Berita Berhasil Diubah!', $berita);
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        //delete image
        Storage::delete('public/berita/'.$berita->image);

        //delete berita
        $berita->delete();

        //return response
        return new BeritaResource(true, 'Data Berita Berhasil Dihapus!', null);
    }




}

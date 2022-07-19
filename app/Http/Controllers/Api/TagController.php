<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tag = Tag::latest()->paginate(5);

        //return collection of posts as a resource
        return new TagResource(true, 'List Data Tag', $tag);

    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'slug'     => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

       //insert tag
        $tag = Tag::create([
            'name'       => $request->name,
            'slug'        => Str::slug($request->slug, '-'),
        ]);

        //return response
        return new TagResource(true, 'Tag Berita Berhasil Ditambahkan!', $tag);
    }

    public function show($id)
    {
        $tag = Tag::findOrFail($id);

        return new TagResource(true, 'Data Tag Ditemukan!', $tag);
    }


    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'slug'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

            $tag = Tag::findOrFail($id);

            $tag->update([
                'name'     => $request->name,
                'slug'   => Str::slug($request->slug, '-'),
            ]);


        //return response
        return new TagResource(true, 'Data Tag Berhasil Diubah!', $tag);
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        //return response
        return new TagResource(true, 'Data Tag Berhasil Dihapus!', null);
    }
}

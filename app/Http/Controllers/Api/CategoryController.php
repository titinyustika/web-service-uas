<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::latest()->paginate(5);

        //return collection of posts as a resource
        return new CategoryResource(true, 'List Data Category', $category);

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

       //insert category
        $category = Category::create([
            'name'       => $request->name,
            'slug'        => Str::slug($request->slug, '-'),
        ]);

        //return response
        return new CategoryResource(true, 'Category Berita Ditambahkan!', $category);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

        return new CategoryResource(true, 'Data Category Ditemukan!', $category);
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

            $category = Category::findOrFail($id);

            $category->update([
                'name'     => $request->name,
                'slug'   => Str::slug($request->slug, '-'),
            ]);


        //return response
        return new CategoryResource(true, 'Data Category Berhasil Diubah!', $category);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        //return response
        return new CategoryResource(true, 'Data Berhasil Dihapus!', null);
    }

}

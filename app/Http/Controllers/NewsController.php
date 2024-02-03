<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(){
        $news = News::all();
        // return response()->json($news);
        return NewsResource::collection($news->loadMissing('admin:id,username'));
    }

    public function show($id){
        $news = News::findOrFail($id);
        return response()->json(['data' => $news]);
    }

    public function store(Request $request){
        // dd(Auth::user());
        //  $request->file;
        return $request->image;
        $request->validate([
            'rt' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);
        // $image = null;
        // if ($request->file) {
        //     $fileName = $this->generateRandomString();
        //     $extension = $request->file->extension();
        //     $image = $fileName. '.' .$extension;

        //     Storage::putFileAs('image', $request->file, $image);
        // }

        // $request['image'] = $image;
        // $filename = time() . '.' . $request->image->getClientOriginalName();
        // $request->image->storeAs('public/products', $filename);

        // // $request['image'] = $filename;
        // $request['admin_id'] = Auth::user()->id;
        // $post = News::create($request->all());
        // return new NewsResource($post->loadMissing('admin:id,username'));

    }

    public function update(Request $request,$id){
        $request->validate([
            'rt' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        $news = News::findOrFail($id);
        $news->update($request->all());
        return new NewsResource($news->loadMissing('admin:id,username'));
    }

    public function destroy($id){
        $news = News::findOrFail($id);
        $news->delete();
        return "data id: {$id} berhasil dihapus";
    }

    // https://stackoverflow.com/questions/4356289/php-random-string-generator
    function generateRandomString($length = 30) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

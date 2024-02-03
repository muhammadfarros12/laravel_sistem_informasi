<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $request->validate([
            'rt' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);
        $request['admin_id'] = Auth::user()->id;
        $post = News::create($request->all());
        return new NewsResource($post->loadMissing('admin:id,username'));
        // return new NewsResource($post);

        // return response()->json('data');
    }

    public function update(Request $request,$id){
        // $request->validate([
        //     'rt' => 'required',
        //     'title' => 'required',
        //     'description' => 'required',
        // ]);

        $news = News::findOrFail($id);
        $news->update($request->all());
        return new NewsResource($news->loadMissing('admin:id,username'));
    }

    public function destroy($id){
        $news = News::findOrFail($id);
        $news->delete();
        return "data id: {$id} berhasil dihapus";
    }
}

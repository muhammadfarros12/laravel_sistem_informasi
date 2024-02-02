<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(){
        $news = News::all();
        return response()->json($news);
    }

    public function show($id){
        $news = News::findOrFail($id);
        return response()->json(['data' => $news]);
    }
}

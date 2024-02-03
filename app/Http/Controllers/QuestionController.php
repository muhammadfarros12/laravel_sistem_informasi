<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index(){
        $question = Question::all();
        // return response()->json($news);
        return QuestionResource::collection($question->loadMissing('user:id,username'));
    }

    public function show($id){
        $question = Question::findOrFail($id);
        return new QuestionResource($question->loadMissing('user:id,username'));
    }

    public function store(Request $request){
        $request->validate([
            'title' => "required",
            'description' => "required",
        ]);
        $request['user_id'] = Auth::user()->id;
        $post = Question::create($request->all());
        return new QuestionResource($post->loadMissing('user:id,username'));
    }

    public function update(Request $request,$id){
        $request->validate([
            'title' => "required",
            'description' => "required",
        ]);

        $question = Question::findOrFail($id);
        $question->update($request->all());
        return new QuestionResource($question->loadMissing('user:id,username'));
    }

    public function destroy($id){
        $news = Question::findOrFail($id);
        $news->delete();
        return "data id: {$id} berhasil dihapus";
    }
}

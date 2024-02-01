<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Notes;
use Log;

class ApiController extends Controller
{
    public function test(){
        return response()->json("test");
    }
    public function generateSlug(){
        $slug = bin2hex(random_bytes(10));
        $unique = Notes::where("slug", $slug)->count();
        if($unique != 0){
            $slug = $this->generateSlug();
        }
        return $slug;
    }

    public function fetchNote($slug){
        try{
            $note = Notes::where('slug',$slug)->first();
            if($note == null || $note == false){
                Log::channel("note_taking_log")->error("no note with the slug $slug");
                return response()->json(false);
            }

            return response()->json($note);
        }catch( \Throwable $e ){
            Log::channel("note_taking_log")->error($e);
            return response()->json(false);
        }
    }
    public function fetchNotes(){
        try{
            $notes = Notes::orderBy('created_at','desc')->get();
            return response()->json($notes);
        }catch( \Throwable $e ){
            Log::channel("note_taking_log")->error($e);
            return response()->json(false);
        }
    }
    public function createNote(Request $request){
        try{
            $noteData = $request->json()->all();
            $slug = $this->generateSlug();
            Log::channel("note_taking_log")->info($noteData["title"]);
            $note = Notes::create(['slug'=> $slug,'title'=>$noteData["title"],'contents'=>$noteData["contents"],'created_at'=>$noteData["created_at"]]);
            Log::channel("note_taking_log")->info("note created with the ID $note->id");
            return response()->json($note->slug);
        }catch(\Throwable $e){
            Log::channel("note_taking_log")->error($e);
            return response()->json(false);
        }
    }

    public function updateNote(Request $request){
        try{
            $noteData = $request->json()->all();
            $note = Notes::where('slug',$noteData["slug"]);
            if($note->count() == 0){
                Log::channel("note_taking_log")->error("no note with the slug ".$noteData['slug']);
                Log::channel("note_taking_log")->error("$noteData");
                return response()->json(false);
            }
            $note->update(['title'=>$noteData["title"],'contents'=>$noteData["contents"],]);
            Log::channel("note_taking_log")->info("note updated");
            return response()->json(true);
        }catch(\Throwable $e){
            Log::channel("note_taking_log")->error($e);
            return response()->json(false);
        }
    }

    public function deleteNote(Request $request){
        $slug = $request->json()->get("slug");
        
        try{
            $note = Notes::where('slug',$slug)->delete();
            Log::channel("note_taking_log")->info("note deleted with the slug $slug");
            return response()->json(true);
        }catch(\Throwable $e){
            Log::channel("note_taking_log")->error($e);
            return response()->json(false);
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Paper;
use App\Author;
use Illuminate\Http\Request;

class PaperController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'title'     => 'required',
            'abstract'  => 'required',
            'paper'     => 'required|file|between:1,20000'
        ]);

        $path = $request->paper->store('papers');
        
        $paper = Paper::create([
            'title'         => $request->title,
            'abstract'      => $request->abstract,
            'comment'       => $request->comment,
            'path'          => $path,
            'conference_id' => $request->conference_id
        ]);

        // add all the authors
        foreach($request->author as $author_id){
            $paper->authors()->create(['user_id' => $author_id]);
        }
        //send res
        return response()->json([
            'message'   => 'Your Paper has been submitted',
            'paper'     => $paper
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Paper  $paper
     * @return \Illuminate\Http\Response
     */
    public function show(Paper $paper)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Paper  $paper
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paper $paper)
    {
        // if the authenticated user is one of the authors of the paper or a chair of the conference
        // then he can delete it from the the cconference submissions 
        if ($paper->conference->user->id === auth()->id() || $paper->authors->find(auth()->id())) {
            Author::where('paper_id', $paper->id)->delete();
            $paper->delete();
            return response()->json([
                'message' => 'Paper has been deleted'
            ]);
        }

        return response()->json([
            'error' => 'You are not an Author of the Paper or the Chair of the Conference'
        ]);
    }
}

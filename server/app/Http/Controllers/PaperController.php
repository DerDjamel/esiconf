<?php

namespace App\Http\Controllers;

use App\Paper;
use App\Author;
use App\Reviewer;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Paper as PaperResource;
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
        return response()->json($paper);
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

    public function user_papers()
    {
        return response()->json(PaperResource::collection(auth()->user()->papers));
    }

    public function download(Paper $paper)
    {
        return Storage::download($paper->path);
    }

    public function accept_paper(Paper $paper)
    {
        if ($paper->status === 'accepted') return response()->json(['status' => 'OK', 200]);
        $paper->update(['status' => 'accepted']);
        return response()->json([ 'message' => 'Your Paper status has been updated (Accepted)']);
    }

    public function reject_paper(Paper $paper)
    {
        if ($paper->status === 'rejected') return response()->json(['status' => 'OK', 200]);
        $paper->update(['status' => 'rejected']);
        return response()->json([ 'message' => 'Your Paper status has been updated (Rejected)']);
    }



    public function assign_reviewers(Request $request, Paper $paper){        
        $reviewers = Reviewer::find($request->ids);
        
        foreach($reviewers as $reviewer){

            // if he is already a reviwer of the paper then just continue
            if($reviewer->paper_id == $paper->id && $reviewer->conference_id == $paper->conference->id) continue;

            if($reviewer->paper_id == null && $reviewer->conference_id == $paper->conference->id) {
                $reviewer->paper_id = $paper->id;
                $reviewer->save();
            }
            else {
                Reviewer::firstOrCreate([
                    'user_id' => $reviewer->user_id,
                    'conference_id' => $reviewer->conference_id,
                    'paper_id' => $paper->id
                ]);
            }
        }

        return response()->json(['message' => 'All Reviwer have been assigned to the Paper'], 200);

    }
}

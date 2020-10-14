<?php

namespace App\Http\Controllers;

use App\Reviewer;
use App\Conference;
use App\Bid;
use App\User;
use App\Review;
use Illuminate\Http\Request;

class ReviewerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function conference_reviewers(Conference $conference)
    {
        return response()->json($conference->reviewers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Conference $conference)
    {
        if(!($conference->user_id == auth()->id())){
            return response()->json([
                'message' => 'You are not the chairman of the conference'
            ], 403);
        }
        // if he is a chairman
        $user = User::where('email', $request->email)->first();
        if( !$user ){
            return response()->json([
                'message' => $request->email . ' does not exist in our database'
            ], 403); 
        }

        

        return response()->json([
            'reviewer' => Reviewer::firstOrCreate([
                            'user_id' => $user->id,
                            'conference_id' => $conference->id,
                            ]),
            ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reviewer  $reviewer
     * @return \Illuminate\Http\Response
     */
    public function show(Reviewer $reviewer)
    {
        
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reviewer  $reviewer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Conference $conference)
    {
        foreach($request->reviewers as $key => $reviewer){
            Bid::where('reviewer_id', $reviewer['id'])->delete();
            Review::where('reviewer_id', $reviewer['id'])->delete();
            Reviewer::destroy($reviewer['id']);
        }
        return response()->json([
            'message' => 'Reviewer have been removed'
        ],200);
    }
}

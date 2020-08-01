<?php

namespace App\Http\Controllers;

use App\Bid;
use App\Paper;
use App\Reviewer;
use Illuminate\Http\Request;

class BidController extends Controller
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
    public function store(Request $request, Paper $paper)
    {
        // if you are not a reviewer in the paper's conference 
        // then you are not allowed to bid on any papers
        if(!$paper->conference->reviewers->contains('user_id', auth()->id())){
            return response()->json(['message' => 'You are not a reviewer for this Conference']);
        }

        $reviewer = Reviewer::where('user_id', auth()->id())->get();

        Bid::firstOrCreate([
            'intrest_level' => $request->intrest_level,
            'reviewer_id'   => $reviewer[0]->id,
            'paper_id'      => $paper->id
        ]);

        return response()->json([
            'message' => 'Your Bid has been submitted'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function show(Bid $bid)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bid $bid)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bid  $bid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bid $bid)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Review;
use App\Reviewer;
use App\Paper;
use Illuminate\Http\Request;

class ReviewController extends Controller
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
        // the authenticated user must be assigned the paper he is reviewing
        if ( auth()->user()->assigned_papers()->search($paper->id) === false ) 
        {
            return response()->json(['message' => 'You are not a Reviewer of this Paper'], 403);
        }

        // now the user is authenticated and is a reviewer of the paper
        // we can add the review to the database
        Review::firstOrCreate([
            'opinion'       => $request->opinion,
            'comment'       => $request->comment,
            'reviewer_id'   => Reviewer::where('user_id', auth()->id())->get()[0]->id,
            'paper_id'      => $paper->id
        ]);

        return response()->json([
            'message' => 'Your Review has been submitted'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review, Paper $paper)
    {
        // the authenticated user must be assigned the paper he is reviewing
        if ( auth()->user()->assigned_papers()->search($paper->id) === false ) 
        {
            return response()->json(['message' => 'You are not a Reviewer of this Paper'], 403);
        }

        // now the user is authenticated and is a reviewer of the paper
        // we can add the review to the database
        $review->update([
            'opinion'       => $request->opinion,
            'comment'       => $request->comment,
        ]);

        return response()->json([
            'message' => 'Your Review has been Updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }
}

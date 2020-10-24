<?php

namespace App\Http\Controllers;

use App\Review;
use App\Reviewer;
use App\Paper;
use App\Http\Resources\Review as ReviewResource;
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

        $reviewer_id = Review::where('paper_id', $paper->id)->first() ? 
                        Review::where('paper_id', $paper->id)->first()->reviewer_id : null;
        // make sure he does not have a review for this paper
        if (Reviewer::where('user_id', auth()->id())->first()->id === $reviewer_id) {
            return response()->json(['message' => 'You already have a Review for this Paper'], 401);
        }
        
        $request->validate([
            'opinion' => "required",
        ]);

        // now the user is authenticated and is a reviewer of the paper
        // we can add the review to the database
        $review = Review::firstOrCreate([
            'opinion'       => $request->opinion,
            'comment'       => $request->comment,
            'reviewer_id'   => Reviewer::where('user_id', auth()->id())->get()[0]->id,
            'paper_id'      => $paper->id
        ]);

        return response()->json([
            'review_id' => $review->id,
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
        return response()->json($review);
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
            'review' => Review::find($review->id),
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
        if(Reviewer::find($review->reviewer_id)->user_id != auth()->id())
            return response()->json(['message' => 'You are not a Reviewer of this Paper'], 403);

        $review->delete();
        return response()->json([
            'message' => 'Your Review has been Deleted'
        ], 200);
    }

    public function user_reviews()
    {
        return response()->json(ReviewResource::collection(auth()->user()->reviews));
    } 
}

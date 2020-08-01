<?php

namespace App\Http\Controllers;

use App\Conference;
use Illuminate\Http\Request;
use App\Http\Requests\StoreConference;
use App\Http\Resources\Conference as ConferenceResource;
use App\Http\Resources\ConferenceCollection;

class ConferenceController extends Controller
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
        return new ConferenceCollection(Conference::paginate(10));
    }
     

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConference $request)
    {
        $conference = new ConferenceResource(auth()->user()->conferences()->create($request->all()));
        return response()->json([
            'conference'    =>  $conference,
            'message'       => 'Your Conference has been created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Conference  $conference
     * @return \Illuminate\Http\Response
     */
    public function show(Conference $conference)
    {
        return response()->json(new ConferenceResource($conference));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Conference  $conference
     * @return \Illuminate\Http\Response
     */
    public function update(StoreConference $request, Conference $conference)
    {
        $this->authorize('update', $conference);
        $conference->update($request->all());

        return response()->json([
            'conference'    => $conference,
            'message'       => 'Conference has been updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Conference  $conference
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conference $conference)
    {  
        $this->authorize('delete', $conference);
        $conference->delete();
        return response()->json(['message' => 'Conference has been deleted']);
    }

    public function submissionStatus(Conference $conference)
    {
        $this->authorize('papercall', $conference);
    
        $conference->submission_status === 'closed' ? 
            $conference->update(['submission_status' => 'open']) : $conference->update(['submission_status' => 'closed']);

        return response()->json([ 'message' => 'Your conference status has been updated']); 
        
    }

    public function biddingStatus(Conference $conference)
    {
        $this->authorize('biddingStatus', $conference);
    
        $conference->paper_bidding === 'closed' ? 
            $conference->update(['paper_bidding' => 'open']) : $conference->update(['paper_bidding' => 'closed']);

        return response()->json([ 'message' => 'Your conference status has been updated']);
    }
}

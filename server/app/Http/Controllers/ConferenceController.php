<?php

namespace App\Http\Controllers;

use App\Conference;
use Illuminate\Http\Request;
use App\Http\Requests\StoreConference;

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
        // todo : the feed of conferences
    }
     

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConference $request)
    {
        return response()->json([
            'conference'    => auth()->user()->conferences()->create($request->all()),
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
        return response()->json($conference);
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
}

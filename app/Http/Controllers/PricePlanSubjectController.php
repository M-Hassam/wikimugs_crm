<?php

namespace App\Http\Controllers;

use App\Models\PricePlanSubject;
use Illuminate\Http\Request;

class PricePlanSubjectController extends Controller
{
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PricePlanSubject  $pricePlanSubject
     * @return \Illuminate\Http\Response
     */
    public function show(PricePlanSubject $pricePlanSubject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PricePlanSubject  $pricePlanSubject
     * @return \Illuminate\Http\Response
     */
    public function edit(PricePlanSubject $pricePlanSubject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PricePlanSubject  $pricePlanSubject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PricePlanSubject $pricePlanSubject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PricePlanSubject  $pricePlanSubject
     * @return \Illuminate\Http\Response
     */
    public function destroy(PricePlanSubject $pricePlanSubject)
    {
        //
    }

      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $search = $request->q;

        $data = PricePlanSubject::select("id","name")
        ->where('name','LIKE',"%$search%")
        ->get();

        return response()->json($data);
    }
}

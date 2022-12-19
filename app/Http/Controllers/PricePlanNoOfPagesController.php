<?php

namespace App\Http\Controllers;

use App\Models\PricePlanNoOfPage;
use Illuminate\Http\Request;

class PricePlanNoOfPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
     * @param  \App\Models\PricePlanNoOfPage  $pricePlanNoOfPage
     * @return \Illuminate\Http\Response
     */
    public function show(PricePlanNoOfPage $pricePlanNoOfPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PricePlanNoOfPage  $pricePlanNoOfPage
     * @return \Illuminate\Http\Response
     */
    public function edit(PricePlanNoOfPage $pricePlanNoOfPage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PricePlanNoOfPage  $pricePlanNoOfPage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PricePlanNoOfPage $pricePlanNoOfPage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PricePlanNoOfPage  $pricePlanNoOfPage
     * @return \Illuminate\Http\Response
     */
    public function destroy(PricePlanNoOfPage $pricePlanNoOfPage)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function autocomplete(Request $request)
    // {
    //     try {
    //         $data = [];
    //         $queryTerm = $request->q;
    //         $singleSpaced = $request->single_spaced;
    //         $selected = isset($request->selected) ? PricePlanNoOfPage::find($request->selected) : null;
    //         $pricePlanUrgencies = PricePlanNoOfPage::where('name', 'like', '%' . $queryTerm . '%');
    //         // if(isset($singleSpaced)) {
    //         //     $pricePlanUrgencies = $pricePlanUrgencies->where('single_spaced', $singleSpaced);
    //         // }
    //         $pricePlanUrgencies = $pricePlanUrgencies->get();
    //         foreach ($pricePlanUrgencies as $pricePlanNoOfPage) {
    //             $text = (isset($singleSpaced) && (int)$singleSpaced) ? $pricePlanNoOfPage->single_words . ' ' . $pricePlanNoOfPage->name : $pricePlanNoOfPage->double_words . ' ' . $pricePlanNoOfPage->name;
    //             $data[] = ['id' => $pricePlanNoOfPage->id, 'text' => $text, 'selected' => $selected];
    //         }
    //         return $data;
    //     } catch (\Exception $e) {
    //         return $e->getLine();
    //         return ['error' => 'Something went wrong'];
    //     }
    // }

    public function autocomplete(Request $request)
    {
        $search = $request->q;

        $data = PricePlanNoOfPage::select("id","name")
        ->where('name','LIKE',"%$search%")
        ->get();

        return response()->json($data);
    }
}

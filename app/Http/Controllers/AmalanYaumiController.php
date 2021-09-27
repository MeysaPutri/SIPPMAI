<?php

namespace App\Http\Controllers;

use App\Amalan_Yaumi;
use Illuminate\Http\Request;

class AmalanYaumiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("pages.amalan_yaumi.index");
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
     * @param  \App\Amalan_Yaumi  $amalan_Yaumi
     * @return \Illuminate\Http\Response
     */
    public function show(Amalan_Yaumi $amalan_Yaumi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Amalan_Yaumi  $amalan_Yaumi
     * @return \Illuminate\Http\Response
     */
    public function edit(Amalan_Yaumi $amalan_Yaumi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Amalan_Yaumi  $amalan_Yaumi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Amalan_Yaumi $amalan_Yaumi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Amalan_Yaumi  $amalan_Yaumi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Amalan_Yaumi $amalan_Yaumi)
    {
        //
    }
}

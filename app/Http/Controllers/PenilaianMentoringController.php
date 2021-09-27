<?php

namespace App\Http\Controllers;

use App\Penilaian_Mentoring;
use Illuminate\Http\Request;

class PenilaianMentoringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("pages.penilaian.index");
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
     * @param  \App\Penilaian_Mentoring  $penilaian_Mentoring
     * @return \Illuminate\Http\Response
     */
    public function show(Penilaian_Mentoring $penilaian_Mentoring)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Penilaian_Mentoring  $penilaian_Mentoring
     * @return \Illuminate\Http\Response
     */
    public function edit(Penilaian_Mentoring $penilaian_Mentoring)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Penilaian_Mentoring  $penilaian_Mentoring
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penilaian_Mentoring $penilaian_Mentoring)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Penilaian_Mentoring  $penilaian_Mentoring
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penilaian_Mentoring $penilaian_Mentoring)
    {
        //
    }
}

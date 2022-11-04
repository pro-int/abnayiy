<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PermissionCase;
use App\Http\Requests\StorePermissionCaseRequest;
use App\Http\Requests\UpdatePermissionCaseRequest;

class AdminPermissionStatusController extends Controller
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
     * @param  \App\Http\Requests\StorePermissionCaseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionCaseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PermissionCase  $permissionCase
     * @return \Illuminate\Http\Response
     */
    public function show(PermissionCase $permissionCase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PermissionCase  $permissionCase
     * @return \Illuminate\Http\Response
     */
    public function edit(PermissionCase $permissionCase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePermissionCaseRequest  $request
     * @param  \App\Models\PermissionCase  $permissionCase
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionCaseRequest $request, PermissionCase $permissionCase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PermissionCase  $permissionCase
     * @return \Illuminate\Http\Response
     */
    public function destroy(PermissionCase $permissionCase)
    {
        //
    }
}

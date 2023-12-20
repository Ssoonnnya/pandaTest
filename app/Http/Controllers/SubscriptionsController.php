<?php

namespace App\Http\Controllers;

use App\Models\Subscriptions;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    public function index()
    {
        return view('subscription.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'olx_url' => 'required|url'
        ]);

        Subscriptions::create([
            'email' => $request->get('email'),
            'olx_url' => $request->get('olx_url')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(subscriptions $subscriptions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(subscriptions $subscriptions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, subscriptions $subscriptions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(subscriptions $subscriptions)
    {
        //
    }
}

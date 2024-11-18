<?php

namespace App\Http\Controllers\Ussd\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UssdExtension\StoreUssdExtensionRequest;
use App\Models\Event;
use App\Models\UssdExtension;
use Inertia\Inertia;

class UssdExtensionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ussdExtensions = UssdExtension::filter(request()->query('code'))
            ->withCount('events')
            ->orderbyDesc('events_count')
            ->paginate(8);

        return Inertia::render('Ussd/Admin/Index', [
            'ussdExtensions' => $ussdExtensions,
            'search' => request()->query('search'),
            'codes' => UssdExtension::pluck('code')->toArray(),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return Inertia::render('Ussd/Admin/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUssdExtensionRequest $request)
    {
        UssdExtension::create([
            'code' => $request->input('code'),
        ]);

        $ussdExtensions = UssdExtension::filter(request()->query('code'))
            ->withCount('events')
            ->orderbyDesc('events_count')
            ->paginate(8);

        return Inertia::render('Ussd/Admin/Index', [
            'ussdExtensions' => $ussdExtensions,
            'codes' => UssdExtension::pluck('code')->toArray(),

        ])->with('message', 'USSD code created succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $events = Event::with('ussdExtension:id,code')
            ->where('ussd_extension_id', $id)
            ->paginate(8);

        return Inertia::render('Ussd/Admin/Show', [
            'events' => $events,
            'ussdExtension' => UssdExtension::find($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UssdExtension  $ussdExtension
     * @return \Illuminate\Http\Response
     */
    public function edit(UssdExtension $ussdExtension)
    {
        return Inertia::render('Ussd/Admin/Edit', [
            'ussdExtension' => $ussdExtension,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UssdExtension  $ussdExtension
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUssdExtensionRequest $request, UssdExtension $ussdExtension)
    {
        $ussdExtension->code = $request->input('code');
        $ussdExtension->save();

        return back()->with('USSD updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UssdExtension  $ussdExtension
     * @return \Illuminate\Http\Response
     */
    public function destroy(UssdExtension $ussdExtension)
    {
        $ussdExtension->delete();

        return Inertia::render('Ussd/Admin/Index', [
            'ussdExtensions' => UssdExtension::paginate(8),
        ]);
    }
}

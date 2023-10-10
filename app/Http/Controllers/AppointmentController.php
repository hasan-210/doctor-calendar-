<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\GoogleCalendar\Event;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     function __construct()
    {
         $this->middleware('permission:appointment-list|appointment-create|appointment-edit|appointment-delete', ['only' => ['index','show']]);
         $this->middleware('permission:appointment-create', ['only' => ['create','store']]);
         $this->middleware('permission:appointment-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:appointment-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $appointments = Event::get();
        return view('appointments.index',compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('appointments.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'description' => 'required',
            'startDateTime' => 'required',
            'endDateTime' => 'required',
        ]);
        $appointment = new Event();
        $appointment->name = $request->name;
        $appointment->description = $request->description;
        $appointment->startDateTime = Carbon::parse($request->startDateTime);
        $appointment->endDateTime = Carbon::parse($request->endDateTime);
        $appointment->save();
        return redirect()->route('appointments.index')
        ->with('success','appointment created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $appointment = Event::find($id);
        return view('appointments.show',compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $appointment = Event::find($id);
        return view('appointments.edit',compact('appointment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        request()->validate([
            'name' => 'required',
            'description' => 'required',
            'startDateTime' => 'required',
            'endDateTime' => 'required',
        ]);
        $appointment = Event::find($id);
        $appointment->name = $request->name;
        $appointment->description = $request->description;
        $appointment->startDateTime = Carbon::parse($request->startDateTime);
        $appointment->endDateTime = Carbon::parse($request->endDateTime);
        $appointment->save();
        return redirect()->route('appointments.index')
        ->with('success','appointment updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = Event::find($id)->delete();
        return redirect()->route('appointments.index')
        ->with('success','appointment deleted successfully');
    }
}

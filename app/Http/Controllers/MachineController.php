<?php

namespace App\Http\Controllers;

use App\Machine;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $machine = Machine::with('earningSum')->with('emptyUnitCount')->get();

        return view('machines.index', ["machines" => $machine, "today" => Carbon::now()]);
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
        $validated = $request->validate([
                        'name'      => 'required',
                        'status'    => 'required',
                        'arrival_date' => 'date'
                    ]);
        
        Machine::create($validated);

        if( $request->expectsJson() )
        {
            return response(200);
        }

        return redirect(route('machines'))->with("success", $validated['name'] . " has been created");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Machine $machine)
    {
        $date = $machine->created_at;

        if(!auth()->user()->is_admin)
        {
            $date = $machine->units()->where('investor_id', auth()->user()->id)->orderBy('updated_at')->first()->updated_at;
        }

        $earnings = $machine->earnings()->after($date)->orderBy('date')->get();

        return view('machines.show', ['users' => User::all(), 'machine' => $machine, 'earnings' => $earnings, 'total' => $earnings->sum('amount')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Machine $machine)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Machine $machine)
    {
        $validated = $request->validate([
                        'name' => 'required',
                        'status' => 'required',
                        'arrival_date' => 'date'
                    ]);

        $machine->update($validated);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Machine $machine)
    {
        $name = $machine->name;
        $machine->delete();

        return back()->with('success', $name . ' has been deleted.');
    }

    public function get_machines()
    {
        return Machine::all()->filter(function($machine){ return $machine->empty_unit_count > 0; });
    }


    public function get_earnings(Machine $machine)
    {
        $date = $machine->created_at;

        if(!auth()->user()->is_admin)
        {
            $date = $machine->units()->where('investor_id', auth()->user()->id)->orderBy('updated_at')->first()->updated_at;
        }

        $labels = [];
        $data = [];

        foreach($machine->earnings()->after($date)->orderBy('date')->get() as $earning)
        {
            array_push($data, $earning->amount);
            array_push($labels, $earning->date->toDateString());
        }

        return response(['labels' => $labels, 'data' => $data], 200);
    }
}

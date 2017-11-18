<?php

namespace App\Http\Controllers;

use App\Unit;
use App\User;
use Illuminate\Http\Request;

class UnitController extends Controller
{
	public function show(Unit $unit)
	{
		return view('units.show', ['unit' => $unit]);
	}

    public function update(Unit $unit)
    {
    	$data = request()->validate([
    		"investor_id"	=> 'required|numeric|exists:users,id'
    	]);

    	$unit->update($data);

        $user = User::find($data["investor_id"]);
    	return back()->with('success', 'Assigned unit ' . $unit->id . ' to ' . $user->name);
    }
}

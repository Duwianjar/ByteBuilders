<?php

namespace App\Http\Controllers\Client;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Depository;
use App\Models\History;
use App\Models\Category;

class DepositoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'information' => 'required',
            'color' => 'required|regex:/^#[0-9a-fA-F]{6}$/',
        ]);

        $validatedData['id_user'] = Auth::user()->id;

        Depository::create($validatedData);

        return redirect()->back()->with('success', 'Depository created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $depositoried = Depository::where('id_user', Auth::user()->id)->get();
        $depository = Depository::where('id', $id)->first();
        $history = History::where('id_depository', $id)->where('id_user', Auth::user()->id)->orderBy('updated_at', 'desc')->paginate(5);
        $category = Category::where('id_user', Auth::user()->id)->get();
        $user = Auth::user();
        return view('client.depository', compact('depository', 'depositoried', 'user','history','category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'information' => 'required',
            'color' => 'required|regex:/^#[0-9a-fA-F]{6}$/',
        ]);

        $depository = Depository::findOrFail($id);
        $depository->update($validatedData);

        return redirect()->back()->with('success-depository', 'Depository updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $depository = Depository::findOrFail($id);
        $depository->delete();

        return redirect()->to('/dashboard')->with('success', 'Depository deleted successfully.');
    }
}
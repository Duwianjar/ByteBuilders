<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\History;
use App\Models\Depository;

class HistoryController extends Controller
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
            'id_depository' => 'required|string',
            'transaction' => 'required|in:0,1',
            'id_category' => 'required|string',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
        ]);
        $validatedData['id_user'] = Auth::user()->id;
        $depository = Depository::where('id', $validatedData['id_depository'])->first();
        $amount = $validatedData['amount'];
        if ($validatedData['transaction'] == 0) {
            $depository->balance += $amount;
        } else {
            $depository->balance -= $amount;
        }

        if($validatedData['id_category'] == "add_new"){
            $newCategory = [
                'transaction' => $request['transaction'],
                'nama' => $request['new_category'],
                'id_user' => Auth::user()->id,
            ];
            $createdCategory = Category::create($newCategory);
            $validatedData['id_category'] = $createdCategory->id;
            History::create($validatedData);
            $depository->save();
            return redirect()->back()->with('success-transaction', 'History and Category created successfully.');
        }
        History::create($validatedData);
        $depository->save();
        return redirect()->back()->with('success-transaction', 'History created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
            'edit-transaction' => 'required|in:0,1',
            'edit-id_category' => 'required|string',
            'edit-description' => 'nullable|string',
            'edit-amount' => 'required|numeric',
        ]);

        $history = History::findOrFail($id);
        $depository = Depository::findOrFail($history->id_depository);

        if($history->transaction == 0){
            if($history->transaction != $request['edit-transaction']){
                $depository->balance -= $history->amount;
                $depository->balance -= $request['edit-amount'];
            }else{
                $depository->balance -= $history->amount;
                $depository->balance += $request['edit-amount'];
            }
        }else{
            if($history->transaction != $request['edit-transaction']){
                $depository->balance += $history->amount;
                $depository->balance += $request['edit-amount'];
            }else{
                $depository->balance += $history->amount;
                $depository->balance -= $request['edit-amount'];
            }
        }

        $history->transaction = $validatedData['edit-transaction'];
        $history->id_category = $validatedData['edit-id_category'];
        $history->description = $validatedData['edit-description'];
        $history->amount = $validatedData['edit-amount'];

        if($validatedData['edit-id_category'] == "add_new"){
            $newCategory = [
                'transaction' => $request['edit-transaction'],
                'nama' => $request['edit-new_category'],
                'id_user' => Auth::user()->id,
            ];
            $createdCategory = Category::create($newCategory);
            $history->id_category = $createdCategory->id;
            $history->save();
            $depository->save();
            return redirect()->back()->with('success-transaction', 'History and Balance updated successfully.');
        }

        $history->save();
        $depository->save();
        return redirect()->back()->with('success-transaction', 'History and Balance updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $history = History::findOrFail($id);
        $depository = Depository::findOrFail($history->id_depository);
        if ($history['transaction'] == 0) {
            $depository->balance -= $history->amount;
        } else {
            $depository->balance += $history->amount;
        }
        $history->delete();
        $depository->save();

        return redirect()->back()->with('success-transaction', 'History deleted and balance update successfully.');
    }
}
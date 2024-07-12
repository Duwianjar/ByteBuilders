<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Depository;
use Illuminate\Support\Facades\Auth;
use App\Models\History;
use App\Models\Category;

class ExpensesController extends Controller
{
    public function index(){
        $earnings = History::where('transaction', '1')
        ->where('id_user', Auth::user()->id)
        ->with('category')
        ->paginate(5);
        
        $earns = History::where('transaction', '1')
        ->where('id_user', Auth::user()->id)
        ->with('category')
        ->get();

        $categories = Category::where('id_user', Auth::user()->id)->where('transaction', 1)->get();

        $groupedEarnings = $earns->groupBy('id_category');

        $chartData = [];
        foreach ($categories as $category) {
            $categoryEarnings = $groupedEarnings->get($category->id, collect()); // Default to empty collection if null
            $chartData['labels'][] = $category->nama;
            $chartData['data'][] = $categoryEarnings->sum('amount'); // Sum the amount field
            $chartData['backgroundColor'][] = '#' . substr(md5(rand()), 0, 6); // Generate random color
        }
        $depositoried = Depository::where('id_user', Auth::user()->id)->get();
        return view('client.expenses', compact(
            'depositoried',
            'chartData',
            'earnings'
        ));
    }
}
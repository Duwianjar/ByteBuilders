<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Depository;
use Illuminate\Support\Facades\Auth;
use App\Models\History;
use App\Models\Category;

class EarningController extends Controller
{
    public function index(){
        $earnings = History::where('transaction', '0')
        ->where('id_user', Auth::user()->id)
        ->with('category', 'depository')
        ->paginate(5);

        $earns = History::where('transaction', '0')
        ->where('id_user', Auth::user()->id)
        ->with('category', 'depository')
        ->get();

        $categories = Category::where('id_user', Auth::user()->id)->where('transaction', 0)->get();

        $groupedEarnings = $earns->groupBy('id_category');

        $chartData = [];
        foreach ($categories as $category) {
            $categoryEarnings = $groupedEarnings->get($category->id, collect()); 
            $chartData['labels'][] = $category->nama;
            $chartData['data'][] = $categoryEarnings->sum('amount'); 
            $chartData['backgroundColor'][] = '#' . substr(md5(rand()), 0, 6); 
        }
        
        $depositoried = Depository::where('id_user', Auth::user()->id)->get();
        return view('client.earning', compact(
            'depositoried',
            'chartData',
            'earnings'
        ));
    }
}
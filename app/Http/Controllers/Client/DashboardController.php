<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Depository;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function index()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $depositoried = Depository::where('id_user', Auth::user()->id)->get();
        $earning = History::where('id_user', Auth::user()->id)
            ->where('transaction', 0)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('amount');

        $expense = History::where('id_user', Auth::user()->id)
            ->where('transaction', 1)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('amount');

        $balance = $depositoried->sum('balance');

        $months = collect([]);
        $earningsData = collect([]);
        $expensesData = collect([]);

        for ($i = 0; $i < 6; $i++) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->format('F');
            $year = $date->year;

            $months->prepend($month);

            $monthlyEarnings = History::where('id_user', Auth::user()->id)
                ->where('transaction', 0)
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $year)
                ->sum('amount');

            $monthlyExpenses = History::where('id_user', Auth::user()->id)
                ->where('transaction', 1)
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $year)
                ->sum('amount');

            $earningsData->prepend($monthlyEarnings);
            $expensesData->prepend($monthlyExpenses);
        }


        return view('client.dashboard', compact(
            'depositoried',
            'balance',
            'earning',
            'expense',
            'earningsData',
            'expensesData',
            'months'
        ));
    }
    public function month(int $month)
    {
        $currentYear = Carbon::now()->year;
        $depositoried = Depository::where('id_user', Auth::user()->id)->get();

        if ($month == 1) {
            $startDate = Carbon::now()->subMonth();
            $endDate = Carbon::now();

            $earning = History::where('id_user', Auth::user()->id)
                ->where('transaction', 0)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('amount');

            $expense = History::where('id_user', Auth::user()->id)
                ->where('transaction', 1)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('amount');

            $interval = 7;
        } elseif ($month == 3) {
            $startDate = Carbon::now()->subMonths(3);
            $endDate = Carbon::now();

            $earning = History::where('id_user', Auth::user()->id)
                ->where('transaction', 0)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('amount');

            $expense = History::where('id_user', Auth::user()->id)
                ->where('transaction', 1)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('amount');

            $interval = 15;
        } elseif ($month == 6 || $month == 12) {
            $startDate = Carbon::now()->subMonths($month);
            $endDate = Carbon::now();

            $earning = History::where('id_user', Auth::user()->id)
                ->where('transaction', 0)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('amount');

            $expense = History::where('id_user', Auth::user()->id)
                ->where('transaction', 1)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('amount');

            $interval = 30; // This will be treated as monthly interval
        } else {
            $earning = History::where('id_user', Auth::user()->id)
                ->where('transaction', 0)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $currentYear)
                ->sum('amount');

            $expense = History::where('id_user', Auth::user()->id)
                ->where('transaction', 1)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $currentYear)
                ->sum('amount');

            $interval = 30;
        }

        $balance = $depositoried->sum('balance');

        $months = collect([]);
        $earningsData = collect([]);
        $expensesData = collect([]);

        if ($interval == 7 || $interval == 15) {
            $date = Carbon::now();
            while ($date->gt($startDate)) {
                $periodStart = $date->copy()->subDays($interval);
                $period = $periodStart->format('d M') . ' - ' . $date->format('d M');
                $months->prepend($period);

                $periodicEarnings = History::where('id_user', Auth::user()->id)
                    ->where('transaction', 0)
                    ->whereBetween('created_at', [$periodStart, $date])
                    ->sum('amount');

                $periodicExpenses = History::where('id_user', Auth::user()->id)
                    ->where('transaction', 1)
                    ->whereBetween('created_at', [$periodStart, $date])
                    ->sum('amount');

                $earningsData->prepend($periodicEarnings);
                $expensesData->prepend($periodicExpenses);

                $date = $periodStart;
            }
        } else {
            $monthsToRetrieve = $month == 6 ? 6 : 12;
            for ($i = 0; $i < $monthsToRetrieve; $i++) {
                $date = Carbon::now()->subMonths($i);
                $monthName = $date->format('F');
                $year = $date->year;

                $months->prepend($monthName);

                $monthlyEarnings = History::where('id_user', Auth::user()->id)
                    ->where('transaction', 0)
                    ->whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $year)
                    ->sum('amount');

                $monthlyExpenses = History::where('id_user', Auth::user()->id)
                    ->where('transaction', 1)
                    ->whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $year)
                    ->sum('amount');

                $earningsData->prepend($monthlyEarnings);
                $expensesData->prepend($monthlyExpenses);
            }
        }

        return view('client.dashboard', compact(
            'depositoried',
            'balance',
            'earning',
            'expense',
            'earningsData',
            'expensesData',
            'months'
        ));
    }

}
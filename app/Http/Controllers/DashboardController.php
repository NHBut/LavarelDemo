<?php

  namespace App\Http\Controllers;

  use App\Models\User;
  use App\Models\Login;
  use Illuminate\Http\Request;
  use Illuminate\Support\Carbon;
  use Illuminate\Support\Facades\DB;

  class DashboardController extends Controller
  {
      
      public function index()
      {
          try {
              $totalUsers = User::count();
              $totalLogins = Login::count();

              $dates = collect(range(6, 0))->map(function ($i) {
                  return Carbon::today()->subDays($i)->format('Y-m-d');
              });

              $userCounts = [];
              $loginCounts = [];
              foreach ($dates as $date) {
                  $userCounts[$date] = User::whereDate('created_at', $date)->count();
                  $loginCounts[$date] = Login::whereDate('login_at', $date)->count();
              }

              return view('dashboard', compact('totalUsers', 'totalLogins', 'userCounts', 'loginCounts', 'dates'));
          } catch (\Exception $e) {
              \Log::error('Dashboard error: ' . $e->getMessage());
              return redirect()->route('dashboard')->with('error', 'Có lỗi xảy ra. Vui lòng thử lại.');
          }
      }
  }
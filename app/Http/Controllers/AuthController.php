<?php
   namespace App\Http\Controllers;

   use App\Models\User;
   use App\Models\Login;
   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Auth;
   use Illuminate\Support\Facades\Hash;

   class AuthController extends Controller
   {
       public function showRegisterForm()
       {
           return view('auth.register');
       }

       public function register(Request $request)
       {
           $request->validate([
               'name' => 'required|string|max:255',
               'email' => 'required|string|email|max:255|unique:users',
               'password' => 'required|string|min:6|confirmed',
           ]);

           $user = User::create([
               'name' => $request->name,
               'email' => $request->email,
               'password' => Hash::make($request->password),
           ]);

           return redirect()->route('login')->with('success', 'Registration successful! Please login.');
       }

       public function showLoginForm()
       {
           return view('auth.login');
       }

       public function login(Request $request)
       {
           $request->validate([
               'email' => 'required|string|email',
               'password' => 'required|string',
           ]);

           if (Auth::attempt($request->only('email', 'password'))) {
               Login::create([
                   'user_id' => Auth::id(),
                   'login_at' => now(),
               ]);
               return redirect()->route('dashboard')->with('success', 'Login successful!');
           }

           return back()->withErrors(['email' => 'Invalid credentials.']);
       }

       public function logout()
       {
           Auth::logout();
           return redirect()->route('login')->with('success', 'Logged out successfully.');
       }
   }
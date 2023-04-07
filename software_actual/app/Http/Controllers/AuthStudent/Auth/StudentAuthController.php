<?php

namespace App\Http\Controllers\AuthStudent\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class StudentAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.student_login');
    }
    public function studentLogin(Request $request)
    {
        $credentials = $request->only('phone', 'password');

        if (Auth::guard('student')->attempt($credentials)) {
            return redirect()->route('student.profile');
        }

        return redirect()->back()->withInput($request->only('phone'))->withErrors(['phone' => 'Invalid email or password']);
    }
    public function studentLogout()
    {
        Auth::guard('student')->logout();

        return redirect()->route('student.login');
    }

    // public function showRegistrationForm()
    // {
    //     return view('student.register');
    // }

    // public function register(Request $request)
    // {
    //     $this->validate($request, [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:students',
    //         'password' => 'required|string|min:6|confirmed',
    //     ]);

    //     $student = \App\Models\Student::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => bcrypt($request->password),
    //     ]);

    //     Auth::guard('student')->login($student);

    //     return redirect()->route('student.dashboard');
    // }
}

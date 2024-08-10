<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        $mentor = Mentor::select('name','id')->latest()->get();
        return view('user.index', compact('users','mentor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'unique:users,name|string|max:170',
            
            'username' => 'unique:users,username|required|string|max:170',
            'password' => 'required|confirmed|max:32',
            'role' => 'string|max: 30',
            'new_role' => 'unique:users,role|max:30',
        ]);

        $u = new User;
        
        $u->username = $request->username;
        $u->password = bcrypt($request->password);
        if (isset($request->new_role))
        {
            $u->role = $request->new_role;
            $role = $request->new_role;
        }
        else
        {
            $u->role = $request->role;
            $role = $request->role;
        }
        if (isset($request->name))
        {
            $u->name = $request->name;
        }
        else
        {
            $mentor = Mentor::findorFail($request->mentor_name);
            $u->name = $mentor->name;
        }
        
        $u->save();

        $this->message('success', "$role created successfully");
        return redirect()->route('users');

        //return $request;
    }

    public function edit($uid)
    {
        $user = User::find($uid);
        $users = User::select('role')->latest()->get();
        $mentors = Mentor::latest()->get();
        return view('user.edit', compact('user','users','mentors'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required|string|max:170',
            'password' => 'confirmed|max:32',
            'new_role' => 'unique:users,role|nullable|string|max:30',
            'mentor_id' => 'nullable',
        ]);

        $user = User::find($request->id);
        $user->name = $request->name;
        if (isset($request->new_role))
        {
            $user->role = $request->new_role;
        }
        else
        {
            $user->role = $request->role;
        }
        $user->username = $request->username;
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->mentor_id = $request->mentor_id;
        $user->save();

        $this->message('success', 'User updated successfully');
        return redirect()->route('users');
    }

    public function destroy($uid)
    {
        $user = User::find($uid);
        if ($user->course_types->count() > 0) {
            $this->message('error','User can not deleted');
            return redirect()->back();
        } elseif ($user->courses->count() > 0) {
            $this->message('error','User can not deleted');
            return redirect()->back();
        } elseif ($user->mentors->count() > 0) {
            $this->message('error','User can not deleted');
            return redirect()->back();
        } elseif ($user->institutes->count() > 0) {
            $this->message('error','User can not deleted');
            return redirect()->back();
        } elseif ($user->batches->count() > 0) {
            $this->message('error','User can not deleted');
            return redirect()->back();
        } elseif ($user->students->count() > 0) {
            $this->message('error','User can not deleted');
            return redirect()->back();
        } elseif ($user->accounts->count() > 0) {
            $this->message('error','User can not deleted');
            return redirect()->back();
        } elseif ($user->payments->count() > 0) {
            $this->message('error','User can not deleted');
            return redirect()->back();
        } elseif ($user->teachers->count() > 0) {
            $this->message('error','User can not deleted');
            return redirect()->back();
        } else {
            $user->delete();
            $this->message('success', 'User deleted successfully');
            return redirect()->route('users');
        }
    }

    public function isAdmin()
    {
        if (Auth::user()->role != 'admin') {
            return redirect()->route('home');
        }
    }
}

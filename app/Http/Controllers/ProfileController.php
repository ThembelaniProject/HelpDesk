<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $stats = [

    'total' => Ticket::where('user_id',$user->id)->count(),

    'open' => Ticket::where('user_id',$user->id)
        ->where('status','Open')
        ->count(),

    'resolved' => Ticket::where('user_id',$user->id)
        ->where('status','Resolved')
        ->count(),

    'closed' => Ticket::where('user_id',$user->id)
        ->where('status','Closed')
        ->count(),

];

return view('profile.edit', compact('user','stats'));
    }

    public function update(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'profile_photo' => 'nullable|image|max:2048'
    ]);

    /** @var \App\Models\User $user */
    $user = Auth::user();

    if ($request->hasFile('profile_photo')) {

        $photo = $request->file('profile_photo')
            ->store('profiles', 'public');

        $user->profile_photo = $photo;
    }

    $user->name = $request->name;
    $user->email = $request->email;

    $user->save();

    return back()->with('success', 'Profile updated successfully.');
}

    public function password(Request $request)
    {
        $request->validate([

            'current_password'=>'required',

            'password'=>'required|min:8|confirmed'

        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if(!Hash::check(
            $request->current_password,
            $user->password
        ))
        {
            return back()->withErrors([
                'current_password'=>'Current password is incorrect.'
            ]);
        }

        $user->password = Hash::make($request->password);

        $user->save();

        return back()->with('success','Password updated.');
    }
}
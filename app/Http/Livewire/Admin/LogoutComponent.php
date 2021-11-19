<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LogoutComponent extends Component
{
    public function render()
    {
        return view('livewire.admin.logout-component');
    }

    public function logout()
    {
        //dd('logouted');
        Auth::logout();
        return redirect(route('login'));
    }
}

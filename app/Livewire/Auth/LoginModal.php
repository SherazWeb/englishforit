<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class LoginModal extends Component
{
    public $email = '';
    public $password = '';
    public $name = ''; // For registration
    public $error;

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Manually store previous URL
        if (!session()->has('url.intended')) {
            session(['url.intended' => url()->previous()]);
        }

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            $this->dispatch('close-login-modal');

            return redirect()->intended('/');
        } else {
            $this->error = 'Invalid email or password.';
        }
    }

    public function register()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ]);

        Auth::login($user);
        session()->regenerate();
        $this->dispatch('close-login-modal');

        return redirect()->intended('/');
    }

    public function render()
    {
        return view('livewire.auth.login-modal');
    }
}

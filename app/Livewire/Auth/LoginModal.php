<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginModal extends Component
{
    public $email;
    public $password;
    public $remember = false;
    public $showModal = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    public function toggleModal()
    {
        $this->showModal = !$this->showModal;
        $this->resetErrorBag();
    }

    public function login()
    {
        $this->validate();

        if (Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], $this->remember)) {
            $this->showModal = false;
            $this->dispatch('userLoggedIn');
            return redirect()->intended('/'); // Refresh to update UI
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    public function logout()
    {
        Auth::logout();
        $this->dispatch('userLoggedOut');
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.auth.login-modal', [
            'user' => Auth::user() // Pass user data to the view
        ]);
    }
}
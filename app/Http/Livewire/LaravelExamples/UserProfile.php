<?php

namespace App\Http\Livewire\LaravelExamples;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class UserProfile extends Component
{
    public User $user;
    public $showSuccesNotification  = false;

    public $showDemoNotification = false;

    protected $rules = [
        'user.name' => 'max:40|min:3',
        'user.email' => 'email:rfc,dns',
        'user.phone' => 'max:10',
        'user.about' => 'max:200',
        'user.location' => 'min:3',
        'user.password'=>'min:8',
    ];

    public function mount() {
        $this->user = auth()->user();
        $this->user->password = '';
    }

    public function save() {
        $this->validate();

        if(strlen($this->user->password)>0){

            $this->user->password = Hash::make($this->user->password);
        }
        $this->user->save();
        $this->user->password='';
        $this->showSuccesNotification = true;

    }
    public function render()
    {
        return view('livewire.laravel-examples.user-profile');
    }
}

<?php

namespace Eren\Lms\HttpLivewire;

use Eren\Lms\Models\User;
use Livewire\Component;

class EditAdmin extends Component
{
    public $user;
    public function mount($user)
    {
        $this->user = User::select('id','name','email')->where('id',$user)->first();
    }
    public function render()
    {
        return view('livewire.edit-admin')
            ->extends('admin.admin_main')
            ->section('content')
            ;
    }
}

<?php

namespace Eren\lms\HttpLivewire;


use Livewire\Component;

class CreateAdmin extends Component
{
    public function render()
    {
        return view('livewire.create-admin')
            ->extends('admin.admin_main')
            ->section('content');
    }
}

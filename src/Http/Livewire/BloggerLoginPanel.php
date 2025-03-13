<?php

namespace Eren\lms\HttpLivewire;

use Livewire\Component;

class BloggerLoginPanel extends Component
{
    public function render()
    {
        return view('livewire.blogger-login-panel')
            ->layout('layouts.main');
    }
}

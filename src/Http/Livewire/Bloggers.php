<?php

namespace Eren\lms\HttpLivewire;

use Livewire\Component;

class Bloggers extends Component
{
    public $users;
    public function render()
    {
        return view('livewire.bloggers');
    }
}

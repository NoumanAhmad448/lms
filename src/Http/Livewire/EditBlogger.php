<?php

namespace Eren\lms\HttpLivewire;

use Livewire\Component;

class EditBlogger extends Component
{

    public $user;

    public function render()
    {
        return view('livewire.edit-blogger');
    }
}

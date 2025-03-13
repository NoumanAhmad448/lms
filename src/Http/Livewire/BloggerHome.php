<?php

namespace Eren\lms\HttpLivewire;

use Eren\Lms\Models\Faq;
use Eren\Lms\Models\Post;
use Eren\Lms\Models\Setting;
use Livewire\Component;

class BloggerHome extends Component
{
    public $t_faq;
    public $t_post;
    private $title;
    public $setting;

    public function mount()
    {
        $this->t_faq = Faq::count();
        $this->t_post = Post::count();
        $this->title = trans('messages.blogger_home');
        $this->setting = Setting::select('isBlog','isFaq')->first();
    }

    public function render()
    {
        return view('livewire.blogger-home')
            ->extends('bloggers.blogger_main',['title' => $this->title, 'setting' => $this->setting])
            ->section('content');

    }
}

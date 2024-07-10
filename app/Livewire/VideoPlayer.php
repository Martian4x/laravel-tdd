<?php

namespace App\Livewire;

use App\Models\Video;
//use Illuminate\View\View;
use Livewire\Component;

class VideoPlayer extends Component
{
//    public Video $video;
    public $video;
    public $courseVideos;

    public function mount()
    {
        $this->courseVideos = $this->video->course->videos;
    }

//    public function mount(Video $video)
//    {
//        $this->video = $video;
//    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.video-player');
    }

    public function markVideoAsCompleted(): void
    {
        auth()->user()->videos()->attach($this->video);
    }

    public function markVideoAsNotCompleted(): void
    {
        auth()->user()->videos()->detach($this->video);
    }

    public function isCurrentVideo(Video $videoToCheck): bool
    {
        return $this->video->id === $videoToCheck->id;
    }
}

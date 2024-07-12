<div>
    <iframe src="https://player.vimeo.com/video/{{ $video->vimeo_id }}" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
    <h3>{{ $video->title }} ({{ $video->getReadableDuration() }})</h3>
    <p>{{ $video->description }}</p>
    @if($video->alreadyWatchedByCurrentUser())
        <button wire:click="markVideoAsNotCompleted">Mark as Not Completed</button>
    @else
        <button wire:click="markVideoAsCompleted">Mark as Completed</button>
    @endif

    @foreach($courseVideos as $courseVideo)
        <li>
            @if($this->isCurrentVideo($courseVideo))
                {{ $courseVideo->title }}
            @else
                <a href="{{ route('pages.course-videos', $courseVideo) }}">
                    {{ $courseVideo->title }}
             @endif
            </a>
        </li>
    @endforeach
</div>

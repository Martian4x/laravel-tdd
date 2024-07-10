<div>
    <iframe src="https://player.vimeo.com/video/{{ $video->video_id }}" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
    <h3>{{ $video->title }} ({{ $video->getReadableDuration() }})</h3>
    <p>{{ $video->description }}</p>

    @foreach($courseVideos as $courseVideo)
        <li>
            @if($this->video->id === $courseVideo->id)
                {{ $courseVideo->title }}
            @else
                <a href="{{ route('pages.course-videos', $courseVideo) }}">
                    {{ $courseVideo->title }}
             @endif
            </a>
        </li>
    @endforeach
</div>

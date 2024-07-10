<div>
    <iframe src="https://player.vimeo.com/video/{{ $video->video_id }}" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
    <h3>{{ $video->title }} ({{ $video->getReadableDuration() }})</h3>
    <p>{{ $video->description }}</p>

    @foreach($courseVideos as $courseVideo)
        <li>
            <a href="{{ route('pages.course-videos', $courseVideo) }}">
                {{ $courseVideo->title }}
            </a>
        </li>
    @endforeach
</div>

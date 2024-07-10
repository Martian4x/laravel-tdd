<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Course Details</title>
</head>
<body>
    <h2>{{ $course->title }}</h2>
{{--    <img src="{{ asset("images/$course->image") }}" alt="Course Image">--}}
    <img src="{{ $course->image }}" alt="Course Image">
    <h3>{{ $course->tagline }}</h3>
    <p>{{ $course->description }}</p>
    <p>{{ $course->videos_count }} videos</p>

    <p>
        <ur>
            @foreach($course->learnings as $learning)
                {{ $learning }}
            @endforeach
        </ur>
    </p>

</body>
</html>

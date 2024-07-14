<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Document</title>
</head>
<body>
@guest()
    <a href="{{ route('login') }}">Login</a>
@else
    <form action="{{ route('logout') }}" method="POST" >
        @csrf
        <button type="submit">Log Out</button>
    </form>
@endguest

    @foreach($courses as $course)
        <h3>{{ $course->title }}</h3>
        <p>{{ $course->description }}</p>
    @endforeach


</body>
</html>

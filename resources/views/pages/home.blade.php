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
<a href="{{ route('login') }}">Login</a>
    @foreach($courses as $course)
        <h3>{{ $course->title }}</h3>
        <h3>{{ $course->description }}</h3>
    @endforeach


</body>
</html>

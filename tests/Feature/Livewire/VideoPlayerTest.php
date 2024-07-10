<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\User;
use App\Models\Video;

function createCourseVideo(int $videosCount=1): Course
{
    return Course::factory()->has(Video::factory()->count($videosCount))->create();
}

it('shows details for given video', function () {
    //Arrange
    $course = createCourseVideo();
//    dd($course);
    // Act & Assert
    loginAsUser();
    $video = $course->videos->first();
    Livewire::test(VideoPlayer::class, ['video'=>$video])
        ->assertSeeText([
            $video->title,
            $video->description,
            "({$video->duration_mn}min)",
        ]);
});

it('show given video', function () {
    // Arrange
    $course = createCourseVideo();

    // Act & Assert
    loginAsUser();
    $video = $course->videos->first();
    Livewire::test(VideoPlayer::class, ['video'=>$video])
        ->assertSeeHtml('<iframe src="https://player.vimeo.com/video/'.$video->vimeo_id.'"');
});

it('shows list of all course videos', function () {
    // Arrange
    $course = createCourseVideo(3);

    // Act & Assert
    loginAsUser();
    Livewire::test(VideoPlayer::class, ['video'=>$course->videos->first()])
        ->assertSee([
            ...$course->videos->pluck('titles')->toArray() //... is a spread operator
        ])->assertSeeHtml([
            route('pages.course-videos', $course->videos[1]),
            route('pages.course-videos', $course->videos[2]),
        ]);
});

it('does not include route for current video', function () {
    // Arrange
    $course = createCourseVideo();

    // Act & Assert
    loginAsUser();
    Livewire::test(VideoPlayer::class, ['video'=>$course->videos->first()])
        ->assertSee([
            ...$course->videos->pluck('titles')->toArray() //... is a spread operator
        ])->assertDontSeeHtml(route('pages.course-videos', $course->videos()->first()));

});

it('marks video as completed', function () {
    // Arrange
    $user = User::factory()->create();
    $course = createCourseVideo();

    $user->courses()->attach($course);

    // Assert
    expect($user->videos)->toHaveCount(0);

    // Act & Assert
    loginAsUser($user);
    Livewire::test(VideoPlayer::class, ['video'=>$course->videos()->first()])
            ->assertMethodWired('markVideoAsCompleted')
            ->call('markVideoAsCompleted')
            ->assertMethodNotWired('markVideoAsCompleted')
            ->assertMethodWired('markVideoAsNotCompleted');

    //Assert
    $user->refresh(); // So it refer to the previous declared user
    expect($user->videos)->toHaveCount(1)
        ->first()->title->toEqual($course->videos->first()->title);
});

it('marks video as not completed', function (){
    // Arrange
    $user = User::factory()->create();
    $course = createCourseVideo();
    $course = createCourseVideo();

    $user->courses()->attach($course);
    $user->videos()->attach($course->videos()->first());

    // Assert
    expect($user->videos)->toHaveCount(1);

    // Act & Assert
    loginAsUser($user);
    Livewire::test(VideoPlayer::class, ['video'=>$course->videos()->first()])
        ->assertMethodWired('markVideoAsNotCompleted')
        ->call('markVideoAsNotCompleted')
        ->assertMethodNotWired('markVideoAsNotCompleted')
        ->assertMethodWired('markVideoAsCompleted');

    //Assert
    $user->refresh(); // So it refer to the previous declared user
    expect($user->videos)->toHaveCount(0);
});


<?php

use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Sequence;

it('shows details for given video', function () {
    $course = Course::factory()->has(Video::factory())->create();

    // Act & Assert
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
    $course = Course::factory()
        ->has(Video::factory())->create();

    // Act & Assert
    $video = $course->videos->first();
    Livewire::test(VideoPlayer::class, ['video'=>$video])
        ->assertSeeHtml('<iframe src="https://player.vimeo.com/video/'.$video->video_id.'"');
});

it('shows list of all course videos', function () {
    // Arrange
    $course = Course::factory()
        ->has(Video::factory()
        ->count(3)
        )->create();

    // Act & Assert
    Livewire::test(VideoPlayer::class, ['video'=>$course->videos->first()])
        ->assertSee([
            ...$course->videos->pluck('titles')->toArray() //... is a spread operator
        ])->assertSeeHtml([
            route('pages.course-videos', $course->videos[0]),
            route('pages.course-videos', $course->videos[1]),
            route('pages.course-videos', $course->videos[2]),
        ]);
});

it('marks video as completed', function () {
    // Arrange
    $user = User::factory()->create();
    $course = Course::factory()->has(Video::factory()->state(['title'=>'Course Video']))->create();

    $user->courses()->attach($course);

    // Assert
    expect($user->videos)->toHaveCount(0);

    // Act & Assert
    loginAsUser($user);
    Livewire::test(VideoPlayer::class, ['video'=>$course->videos()->first()])
            ->call('markVideoAsCompleted');

    //Assert
    $user->refresh(); // So it refeer to the previous declared user
    expect($user->videos)->toHaveCount(1)
        ->first()->title->toEqual('Course Video');
});

it('marks video as not completed', function (){
    // Arrange
    $user = User::factory()->create();
    $course = Course::factory()->has(Video::factory()->state(['title'=>'Course Video']))->create();

    $user->courses()->attach($course);
    $user->videos()->attach($course->videos()->first());

    // Assert
    expect($user->videos)->toHaveCount(1);

    // Act & Assert
    loginAsUser($user);
    Livewire::test(VideoPlayer::class, ['video'=>$course->videos()->first()])
        ->call('markVideoAsNotCompleted');

    //Assert
    $user->refresh(); // So it refer to the previous declared user
    expect($user->videos)->toHaveCount(0);
});


<?php


use App\Models\Course;
use App\Models\User;
use App\Models\Video;

test('video belongs to a course', function () {
    // Arrange
    $video = Video::factory()->has(Course::factory())
        ->create();

    // Act & Assert
    expect($video->course)
        ->toBeInstanceOf(Course::class);
});

test('gives back readable video duration', function () {

    // Arrange
    $video = Video::factory()->create(['duration_mn'=>10]);

    // Act & Assert
    expect($video->getReadableDuration())->toEqual('10min');
});

it('tells if current user has not yet watched a given video', function (){
    // Arrange
    $video = Video::factory()->create();

    // Act & Assert
    loginAsUser();
    expect($video->alreadyWatchedByCurrentUser())->toBeFalse();
});

it('tells if current user has already watched a given video', function (){
    // Arrange
    $user = User::factory()
        ->has($video = Video::factory()) // watched_videos
        ->create();

    // Act & Assert
    loginAsUser($user);
    expect($user->videos()->first()->alreadyWatchedByCurrentUser())->toBe(true);
});

<?php


use App\Models\Course;
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

    // Act &Assert
    expect($video->getReadableDuration())->toEqual('10min');
});

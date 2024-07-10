<?php

use App\Models\Course;
use App\Models\Video;

//uses(RefreshDatabase::class); // Already done in Pest.php file


test('does not show unreleased course', function () {
    // Arrange
    $course = Course::factory()->create();

    // Act & Assert
    $this->get(route('pages.course-details', $course))->assertNotFound();
});

test('show course details', function () {
    $course = Course::factory()->released()->create();

    // Act & Assert
    $this->get(route('pages.course-details', $course))
        ->assertOk()
        ->assertSeeText([
//            $course->slug,
            $course->tagline,
            $course->title,
            $course->description,
            ...$course->learnings,
        ])
        ->assertSee($course->image);
//    ->assertSee(asset("images/$course->image"));
//        ->assertSee('image.png');
});

it('shows course video count', function () {

    // Arrange
//    $this->withoutExceptionHandling();
    $course = Course::factory()
        ->has(Video::factory()->count(3))
        ->released()
        ->create();
//    Video::factory()->count(3)->create(['course_id'=>$course->id]);

    // Act
    $this->get(route('pages.course-details', $course))
        ->assertOk() // Always make sure to make an OK assertion when you make a get/post/http requests then an assertion
        ->assertSeeText('3 videos');
});

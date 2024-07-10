<?php

use App\Models\Course;
use function Pest\Laravel\get;

//uses(RefreshDatabase::class); // Make the DB exist

// Tests are like documentation for your project

test('shows courses overview', function () {
    // Arrange
    $firstCourse = Course::factory()->released()->create();
    $secondCourse = Course::factory()->released()->create();
    $thirdCourse = Course::factory()->released()->create();

    // Act and Assert
    get(route('pages.home'))
        ->assertSeeText([
            $firstCourse->title,
            $firstCourse->description,
            $secondCourse->title,
            $secondCourse->description,
            $thirdCourse->title,
            $thirdCourse->description,
        ]);
});


test('does not show unreleased courses', function () {
    // Arrange
    $course = Course::factory()->create();

    // Act & Assert
    $this->get('/')->assertOk()->assertDontSeeText([
        $course->title,
        $course->description
    ]);
});

test('shows only released courses', function () {
    // Arrange
     $releasedCourse = Course::factory()->released()->create();
     $notReleasedCourse = Course::factory()->create();

     // Act && Assert
    get(route('pages.home'))
        ->assertSeeText($releasedCourse->title)
        ->assertDontSeeText($notReleasedCourse->title);
});

test('shows courses by release date', function () {
    // Arrange
    $releasedCourse = Course::factory()->released(\Illuminate\Support\Carbon::yesterday())->create();
    $newestReleasedCourse = Course::factory()->released()->create();

    // Act && Assert
    get(route('pages.home'))
        ->assertSeeTextInOrder([
            $newestReleasedCourse->title,
            $releasedCourse->title
        ]);

});

test('includes login if not logged in', function () {
    // Arrange
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeText('Login')
        ->assertSee(route('login'));

    // Act
});

test('includes logout if logged in', function () {
    loginAsUser();
    // Arrange
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeText('Log Out')
        ->assertSee(route('logout'));

    // Act
});

<?php

use App\Models\Course;
use App\Models\User;
use App\Models\Video;

test('gives back successful response for home page', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

it('gives back successful response for course detail page', function () {
    // Arrange
    $course = Course::factory()->released()->create();

    // Act and Assert
    $this->get(route('pages.course-details', $course))
        ->assertOk();
});

it('gives back successful response for dashboard page', function () {
    // Arrange
    loginAsUser();
    $this->get(route('pages.dashboard'))
        ->assertOk();
});

it('does not find the JetStream Registration page', function () {
    // Assert & Act
    $this->get('register')->assertNotFound();
});

it('gives successful response for videos page', function () {
    // Arrange
    $course = Course::factory()
        ->has(Video::factory())
        ->create();

    // Act& Assert
    loginAsUser();
    $this->get(route('pages.course-videos', $course))
        ->assertOk();
});

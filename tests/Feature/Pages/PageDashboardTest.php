<?php

use App\Models\Course;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;

//uses(RefreshDatabase::class);

test('cannot be accessed by a guest', function () {
    $this->get(route('pages.dashboard'))
        ->assertRedirect(route('login'));
});

it('list purchased courses', function () {
    $user = User::factory()
        ->has(Course::factory()->count(2)
            ->state(
            new Sequence(
                    ['title'=>'Course A'],
                    ['title'=>'Course B'],
            )
        ))
        ->create();

    // Act
//    $this->actingAs($user);
    loginAsUser($user);
    $this->get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText(
            ['Course A', 'Course B']
        );
});

it('does not list other courses', function () {
    // Arrange
    $course = Course::factory()->create();

    // Act & Assert
    loginAsUser();
    $this->get(route('pages.dashboard'))
        ->assertOk()
        ->assertDontSeeText($course->test);

});

it('shows latest purchased course first', function () {
    // Arrange
    $user = User::factory()->create();
    $firstPurchasedCourse = Course::factory()->create();
    $lastPurchasedCourse = Course::factory()->create();

    $user->courses()->attach($firstPurchasedCourse, ['created_at' => Carbon::yesterday()]);
    $user->courses()->attach($lastPurchasedCourse, ['created_at' => Carbon::now()]);

    // Act
    loginAsUser($user);
    $this->get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeInOrder([
            $lastPurchasedCourse->title,
            $firstPurchasedCourse->title
        ]);

});

it('includes link to product videos', function () {
    // Arrange
    $user = User::factory()
        ->has(Course::factory())
        ->create();

    // Act & Assert
    $this->actingAs($user);
    $this->get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText('Watch Videos')
        ->assertSee(route('pages.course-videos', Course::first()));

});

it('includes login', function () {
    // Act & Assert
    loginAsUser();
    $this->get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText('Log Out')
        ->assertSee(route('logout'));
});

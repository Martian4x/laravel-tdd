<?php


use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Facades\App;

test('adds given courses', function () {
    // Assert
    $this->assertDatabaseCount(Course::class, 0); // Make sure there are no Courses in the DB

    // Act
    $this->artisan('db:seed');

    // Assert
    $this->assertDatabaseCount(Course::class, 3);
    $this->assertDatabaseHas(Course::class, ['title'=>'Laravel For Beginners']);
    $this->assertDatabaseHas(Course::class, ['title'=>'Advanced Laravel']);
    $this->assertDatabaseHas(Course::class, ['title'=>'TDD The Laravel Way']);

});

it('adds given courses only once', function () {
    // Act
    $this->artisan('db:seed');
    $this->artisan('db:seed');

    // Assert
    $this->assertDatabaseCount(Course::class, 3);
});

it('adds vigen videos', function () {
    // Assert
    $this->assertDatabaseCount(Video::class, 0);

    // Act
    $this->artisan('db:seed');

    // Assert
    $laravelForBeginnersCourse = Course::where('title', 'Laravel For Beginners')->firstOrFail();
    $advancedLaravelCourse = Course::where('title', 'Advanced Laravel')->firstOrFail();
    $tddTheLaravelWayCourse = Course::where('title', 'TDD The Laravel Way')->firstOrFail();
    $this->assertDatabaseCount(Video::class, 8);

    expect($laravelForBeginnersCourse->videos)->toHaveCount(3)
        ->and($advancedLaravelCourse->videos)->toHaveCount(3)
        ->and($tddTheLaravelWayCourse->videos)->toHaveCount(2);
});

it('adds given videos only once', function () {
    // Assert
    $this->assertDatabaseCount(Video::class, 0);

    // Act
    $this->artisan('db:seed');
    $this->artisan('db:seed');

    // Assert
    $this->assertDatabaseCount(Video::class, 8);
});

test('adds local test use', function () {
    // Arrange
    App::partialMock()->shouldReceive('environment')->andReturn('local');
//    config()->set('app.env', 'local'); // Won't work because the environment is already set

    // Assert
    $this->assertDatabaseCount(User::class,0);

    // Act
    $this->artisan('db:seed');

    // Assert
    $this->assertDatabaseCount(User::class, 1);
});

test('does not add test user for production', function () {
    App::partialMock()->shouldReceive('environment')->andReturn('production');
    // Assert
//    $this->assertDatabaseCount(User::class,0);
    $this->assertDatabaseEmpty(User::class);

    // Act
    $this->artisan('db:seed');

    // Assert
    $this->assertDatabaseCount(User::class, 0);
});

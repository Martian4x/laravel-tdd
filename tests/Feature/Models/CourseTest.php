<?php

use App\Models\Course;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;

//uses(RefreshDatabase::class);


//it('only returns released courses for released scope', function () {
//    // Arrange
//    Course::factory()->released()->create();
//    Course::factory()->create();
//
//    // Act & Assert
//
//    expect(Course::released()->get())
//        ->toHaveCount(1)
//        ->first()->id->toEqual(1);
//
////    // Act & Assert
////    $this->assertCount(1, Course::released()->get());
////    $this->assertEquals(1, Course::released()->first()->id);
//});

// 

it('has videos', function () {
    // Arrange
    $course = Course::factory()->create();
    Video::factory()->count(3)->create(['course_id'=>$course->id]);

    // Act & Assert
    $this->expect($course->videos)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(Video::class);
});

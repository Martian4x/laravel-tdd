<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class AddLocalTestUserSeeder extends Seeder
{
    public function run(): void
    {
//        if(env('APP_ENV')=='local'){
        if(App::environment()==='local'){
            $user = User::create([
                'email'=>'test@test.at',
                'name'=>'Mike',
                'password'=>bcrypt('test'),
            ]);

            $user->courses()->attach(Course::all());
        }
    }
}

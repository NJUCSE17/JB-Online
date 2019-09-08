<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $userID = DB::table('users')->insertGetId([
            'student_id'        => '10000',
            'name'              => 'admin',
            'email'             => 'admin@admin.com',
            'email_verified_at' => now(),
            'activated_at'      => now(),
            'password'          => Hash::make('secret'),
        ]);
        $courseID = DB::table('courses')->insertGetId([
            'name'       => 'TestCourse',
            'start_time' => now()->addYears(-1),
            'end_time'   => now()->addYears(1),
        ]);
        DB::table('course_enroll_records')->insert([
            'user_id'   => $userID,
            'course_id' => $courseID,
        ]);
        DB::table('assignments')->insertGetId([
            'course_id'    => $courseID,
            'name'         => 'TestAssignment',
            'content'      => 'test',
            'content_html' => '<p>test</p>',
            'due_time'     => now()->addMonth(),
        ]);
    }
}

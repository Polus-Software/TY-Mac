<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use App\Models\User;
use App\Models\CourseCategory;
use Illuminate\Support\Str;



class CoursesCatalogController extends Controller
{
    public function viewAllCourses()
    {
    
        $courseDetails = [];
        $courses = Course::all();

        foreach($courses as $course)
        {
            $courseCategory = CourseCategory::where('id', $course->category)->value('category_name');

            $assigned = DB::table('assigned_courses')->where('course_id', $course->id)->value('user_id');
        
            $instructorfirstname = User::where('id', $assigned)->value('firstname');
            $instructorlastname = User::where('id', $assigned)->value('lastname');
       
            $courseData =  array (
                'id' => $course->id,
                'course_title' => $course->course_title,
                'course_category' => $courseCategory,
                'description' => $course->description,
                'course_difficulty' => $course->course_difficulty,
                'instructorfirstname' => $instructorfirstname,
                'instructorlastname' => $instructorlastname,
            );
            array_push($courseDetails, $courseData);
        }
        
        return view('Student.allCourses', [
            'courseDetails' => $courseDetails
        ]);
    }

    public function showCourse(){
        return view('Student.showCourse');
    }
}

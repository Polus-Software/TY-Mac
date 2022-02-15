<?php

namespace App\Http\Controllers\CourseCategory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseCategory;
use App\Models\UserType;
use Auth;
use Carbon\Carbon;

class CourseCategoryController extends Controller
{
    public function index() {
        $courseCategories = CourseCategory::paginate(10);
        $user = Auth::user();
        $userTypeLoggedIn =  UserType::find($user->role_id)->user_role;
        return view('CourseCategory.manage_course_categories', [
            'courseCategories' => $courseCategories,
            'userType' => $userTypeLoggedIn
        ]);
    } 

    public function saveCourseCategory(Request $request) {
        
        $html = '';
        $slNo = 1;
        $courseCategoryName = $request->input('category_name');
        $category = new CourseCategory;
        $category->category_name = $courseCategoryName;
        $category->save();

        $courseCategories = CourseCategory::all();
        
        foreach($courseCategories as $courseCategory) {
            $html = $html . '<tr id="' . $courseCategory->id .'">';
            $html = $html . '<th class="align-middle" scope="row">' . $slNo . '</th>';
            $html = $html . '<td class="align-middle" colspan="2">' . $courseCategory->category_name . '</td>';
            $html = $html . '<td class="align-middle text-center"><a title="View course category" data-bs-toggle="modal" data-bs-target="#view_category_modal" data-bs-id="' . $courseCategory->id . '"><i class="fas fa-eye"></i></a>';
            $html = $html . '<a title="Edit course category" data-bs-toggle="modal" data-bs-target="#edit_category_modal" data-bs-id="' . $courseCategory->id . '"><i class="fas fa-pen"></i></a>';
            $html = $html . '<a title="Delete course category" data-bs-toggle="modal" data-bs-target="#delete_category_modal" data-bs-id="' . $courseCategory->id . '"><i class="fas fa-trash-alt"></i></a></td></tr>';
            $slNo = $slNo + 1;
        }
        
        return response()->json(['status' => 'success', 'message' => 'Added successfully', 'html' => $html]);
    } 

    public function viewCourseCategory(Request $request) {
        $courseCategoryId = $request->input('category_id');
        if ($courseCategoryId) {
            $courseCategory = CourseCategory::where('id', $courseCategoryId);
            if ($courseCategory) {
                $data = ['category_name' => $courseCategory->value('category_name'), 'category_added_on' =>  Carbon::createFromFormat('Y-m-d H:i:s', $courseCategory->value('created_at'))->format('m-d-Y')];
               
                return response()->json(['status' => 'success', 'message' => '', 'categoryDetails' => $data]);
            }
        }
        return response()->json(['status' => 'failed', 'message' => 'Some error']);
    }

    public function editCourseCategory(Request $request) {
        $courseCategoryId = $request->input('category_id');
        if ($courseCategoryId) {
            $courseCategory = CourseCategory::where('id', $courseCategoryId);
            if ($courseCategory) {
                $data = ['category_name' => $courseCategory->value('category_name'), 'category_id' => $courseCategory->value('id')];
                return response()->json(['status' => 'success', 'message' => '', 'categoryDetails' => $data]);
            }
        }
        return response()->json(['status' => 'failed', 'message' => 'Some error']);
    }

    public function updateCourseCategory(Request $request) {
        $html = '';
        $slNo = 1;
        $courseCategoryId = $request->input('category_id');
        $courseCategoryName = $request->input('new_category_name');
        if ($courseCategoryId) {
            $courseCategory = CourseCategory::find($courseCategoryId);
            if ($courseCategory) {
                $courseCategory->category_name = $courseCategoryName;
                $courseCategory->save();
                $courseCategories = CourseCategory::all();
                foreach($courseCategories as $courseCategory) {
                    $html = $html . '<tr id="' . $courseCategory->id .'">';
                    $html = $html . '<th class="align-middle" scope="row">' . $slNo . '</th>';
                    $html = $html . '<td class="align-middle" colspan="2">' . $courseCategory->category_name . '</td>';
                    $html = $html . '<td class="align-middle text-center"><a title="View course category" data-bs-toggle="modal" data-bs-target="#view_category_modal" data-bs-id="' . $courseCategory->id . '"><i class="fas fa-eye"></i></a>';
                    $html = $html . '<a title="Edit course category" data-bs-toggle="modal" data-bs-target="#edit_category_modal" data-bs-id="' . $courseCategory->id . '"><i class="fas fa-pen"></i></a>';
                    $html = $html . '<a title="Delete course category" data-bs-toggle="modal" data-bs-target="#delete_category_modal" data-bs-id="' . $courseCategory->id . '"><i class="fas fa-trash-alt"></i></a></td></tr>';
                    $slNo = $slNo + 1;
                }

                return response()->json(['status' => 'success', 'message' => 'Updated successfully', 'html' => $html]);
            }
        }
        return response()->json(['status' => 'failed', 'message' => 'Some error']);
    }

    public function deleteCourseCategory(Request $request) {
        $html = '';
        $slNo = 1;
        $courseCategoryId = $request->input('category_id');
        if ($courseCategoryId) {
            $courseCategory = CourseCategory::find($courseCategoryId);
            if ($courseCategory) {
                $courseCategory->forceDelete();
                $courseCategories = CourseCategory::all();
                if($courseCategories->count()) {
                    foreach($courseCategories as $courseCategory) {
                        $html = $html . '<tr id="' . $courseCategory->id .'">';
                        $html = $html . '<th class="align-middle" scope="row">' . $slNo . '</th>';
                        $html = $html . '<td class="align-middle" colspan="2">' . $courseCategory->category_name . '</td>';
                        $html = $html . '<td class="align-middle text-center"><a title="View course category" data-bs-toggle="modal" data-bs-target="#view_category_modal" data-bs-id="' . $courseCategory->id . '"><i class="fas fa-eye"></i></a>';
                        $html = $html . '<a title="Edit course category" data-bs-toggle="modal" data-bs-target="#edit_category_modal" data-bs-id="' . $courseCategory->id . '"><i class="fas fa-pen"></i></a>';
                        $html = $html . '<a title="Delete course category" data-bs-toggle="modal" data-bs-target="#delete_category_modal" data-bs-id="' . $courseCategory->id . '"><i class="fas fa-trash-alt"></i></a></td></tr>';
                        $slNo = $slNo + 1;
                    }
                } else {
                    $html = $html . '<tr><td colspan="3"><h6 style="text-align:center;">No admins added.</h6></td></tr>';
                }
                
                return response()->json(['status' => 'success', 'message' => 'Updated successfully', 'html' => $html]);
            }
        }
        return response()->json(['status' => 'failed', 'message' => 'Some error', 'test' => $courseCategoryId]);
    }
}



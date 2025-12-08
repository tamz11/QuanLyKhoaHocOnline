<?php
require_once 'BaseController.php';

class StudentController extends BaseController {

    public function dashboard() {
        $this->render('student/dashboard');
    }

    public function myCourses() {
        $this->render('student/my_courses');
    }

    public function courseProgress() {
        $this->render('student/course_progress');
    }

    public function feedback() {
        $this->render('student/feedback');
    }

    public function changePassword() {
        $this->render('student/change_password');
    }
}

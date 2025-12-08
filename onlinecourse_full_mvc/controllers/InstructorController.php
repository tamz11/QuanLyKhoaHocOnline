<?php

require_once 'BaseController.php';

class InstructorController extends BaseController
{
    public function dashboard()
    {
        $this->render('instructor/dashboard');
    }

    // ===========================
    // 1. QUẢN LÝ KHÓA HỌC
    // ===========================
    public function myCourses()
    {
        $this->render('instructor/my_courses');
    }

    // ===========================
    // 2. QUẢN LÝ BÀI HỌC
    // ===========================
    public function lessons()
    {
        $this->render('instructor/lessons/manage');
    }

    public function createLesson()
    {
        $this->render('instructor/lessons/create');
    }

    public function editLesson()
    {
        $this->render('instructor/lessons/edit');
    }

    // ===========================
    // 3. QUẢN LÝ TÀI LIỆU
    // ===========================
    public function materials()
    {
        $this->render('instructor/materials/upload');
    }

    // ===========================
    // 4. DANH SÁCH HỌC VIÊN
    // ===========================
    public function students()
    {
        $this->render('instructor/students/list');
    }

    // ===========================
    // 5. ĐỔI MẬT KHẨU
    // ===========================
    public function changePassword()
    {
        $this->render('instructor/change_password');
    }

    public function updatePassword() {
        echo "Đã nhận dữ liệu đổi mật khẩu của giảng viên!";
    }

}

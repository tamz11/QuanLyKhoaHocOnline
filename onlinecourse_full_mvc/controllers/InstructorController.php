<?php

require_once 'BaseController.php';

class InstructorController extends BaseController
{
    // ===========================
    // DASHBOARD GIẢNG VIÊN
    // ===========================
    public function dashboard()
    {
        $this->requireRole([1, 2]); // giảng viên + admin
        $this->render('instructor/dashboard');
    }

    // ===========================
    // 1. QUẢN LÝ KHÓA HỌC
    // ===========================
    public function myCourses()
    {
        $this->requireRole([1, 2]);
        $this->render('instructor/my_courses');
    }

    // ===========================
    // 2. QUẢN LÝ BÀI HỌC
    // ===========================
    public function lessons()
    {
        $this->requireRole([1, 2]);
        $this->render('instructor/lessons/manage');
    }

    public function createLesson()
    {
        $this->requireRole([1, 2]);
        $this->render('instructor/lessons/create');
    }

    public function editLesson()
    {
        $this->requireRole([1, 2]);
        $this->render('instructor/lessons/edit');
    }

    // ===========================
    // 3. QUẢN LÝ TÀI LIỆU
    // ===========================
    public function materials()
    {
        $this->requireRole([1, 2]);
        $this->render('instructor/materials/upload');
    }

    // ===========================
    // 4. DANH SÁCH HỌC VIÊN
    // ===========================
    public function students()
    {
        $this->requireRole([1, 2]);
        $this->render('instructor/students/list');
    }

    // ===========================
    // 5. ĐỔI MẬT KHẨU
    // ===========================
    public function changePassword()
    {
        $this->requireRole([1, 2]);
        $this->render('instructor/change_password');
    }

    public function updatePassword()
    {
        $this->requireRole([1, 2]);
        echo "Đã nhận dữ liệu đổi mật khẩu của giảng viên!";
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> ccf1cca4de56872d0fe79081a65aaa13f3aa7f09

<?php

class AdminController extends BaseController {

    // Trang dashboard của admin
    public function dashboard() {
        $this->requireRole([2]); // chỉ admin
        $this->render("admin/dashboard");
    }

    // Quản lý user
    public function users() {
        $this->requireRole([2]); // chỉ admin
        $this->render('admin/users/manage');
    }

    // Quản lý danh mục
    public function categories() {
        $this->requireRole([2]); // chỉ admin
        $this->render('admin/categories/list');
    }

    // Duyệt khóa học mới
    public function approveCourses() {
        $this->requireRole([2]);
        $this->render('admin/courses/approve');
    }

    // Form đổi mật khẩu
    public function changePassword() {
        $this->requireRole([2]);
        $this->render('admin/change_password');
    }

    // Xử lý đổi mật khẩu
    public function updatePassword() {
        $this->requireRole([2]);
        echo "Đã nhận dữ liệu đổi mật khẩu của admin!";
    }


}
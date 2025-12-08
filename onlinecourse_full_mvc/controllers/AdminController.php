<?php

class AdminController extends BaseController {

    public function dashboard() {
        $this->render('admin/dashboard');
    }

    public function users() {
        $this->render('admin/users/manage');
    }

    public function categories() {
        $this->render('admin/categories/list');
    }

    // duyệt khóa học mới
    public function approveCourses() {
        $this->render('admin/courses/approve');
    }
    public function changePassword() {
    $this->render('admin/change_password');
    }

    public function updatePassword() {
        echo "Đã nhận dữ liệu đổi mật khẩu của admin!";
    }

}
/**

 * Hiển thị danh sách các giao dịch đã thanh toán
 *

 * @return void

 */

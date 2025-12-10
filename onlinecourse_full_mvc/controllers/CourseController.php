<?php
require_once 'BaseController.php';

class CourseController extends BaseController {

    public function index() {
        $this->render('courses/index');
    }

    public function detail() {
        $this->render('courses/detail');
    }

    public function search() {
        $this->render('courses/search');
    }
}

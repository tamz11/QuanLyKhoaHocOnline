<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../models/Course.php';

class HomeController extends BaseController {

    private $courseModel;

    public function __construct() {
        $this->courseModel = new Course();
    }

    public function index() {
        $popularCourses = $this->courseModel->topCourses();

        $this->render('home/index', [
            'popularCourses' => $popularCourses
        ]);
    }
}

<?php
require_once 'BaseController.php';

class LessonController extends BaseController {

    public function view() {
        $this->render('student/lesson');
    }
}

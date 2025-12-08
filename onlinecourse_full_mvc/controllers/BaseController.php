<?php
abstract class BaseController {
    protected function render($view, $data = []) {
        extract($data);

        include __DIR__ . '/../views/layouts/header.php';
        include __DIR__ . '/../views/' . $view . '.php';
        include __DIR__ . '/../views/layouts/footer.php';
    }
}

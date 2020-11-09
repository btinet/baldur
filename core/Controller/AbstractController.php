<?php


namespace Core\Controller;

use Core\Password;
use Core\Session;
use Core\View\View;

abstract class AbstractController
{
    protected $view;
    protected $session;
    protected $passwordEncoder;

    function __construct()
    {
        $this->view = new View();
        $this->session = new Session();
        $this->session->init();
        $this->passwordEncoder = new Password();
    }

    public static function redirect($status, $url = null) {
        header('Location: ' . host . $url, true, $status);
        exit;
    }

    public static function halt($status = 404, $message = 'Something went wrong.') {
        if (ob_get_level() !== 0) {
            ob_clean();
        }

        http_response_code($status);
        $data['status'] = $status;
        $data['message'] = $message;

        if (!file_exists("/templates/error/$status.php")) {
            $status = 'default';
        }
        require project_root."/templates/error/$status.php";

        exit;
    }

    abstract function index();
}
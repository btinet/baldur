<?php


namespace Core\Controller;

use Core\Password;
use Core\Session;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

abstract class AbstractController
{
    protected $view;
    protected $session;
    protected $passwordEncoder;


    function __construct()
    {

        $debug = ($_ENV['APP_ENV'] !== 'production') ?: true;

        $loader = new FilesystemLoader(project_root.'/templates');
        $this->view = new Environment($loader, [
            'cache' => project_root.'/var/cache',
            'debug' => $debug
        ]);

        if ($debug){
            $this->view->addExtension(new \Twig\Extension\DebugExtension());
        }

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
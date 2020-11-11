<?php


namespace Core\Controller;

use Core\Flash;
use Core\Logger;
use Core\Password;
use Core\Request;
use Core\Session;
use Core\Twig\Extension\FunctionExtension;
use Exception;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

abstract class AbstractController
{

    /**
     * @var Flash
     */
    protected Flash $flash;

    /**
     * @var Logger
     */
    protected Logger $logger;

    /**
     * @var Password
     */
    protected Password $passwordEncoder;

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var Session
     */
    protected Session $session;

    /**
     * @var Environment
     */
    protected Environment $view;

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
        $this->view->addExtension(new FunctionExtension());

        $this->session = new Session();
        $this->session->init();

        $this->flash = new Flash($this->view);
        $this->passwordEncoder = new Password();
        $this->request = new Request();
        $this->request->csrf_token = $this->session->get('csrf_token');
        $this->generateToken();
    }

    public function generateToken(){

        $csrfToken = null;

        try {
            $csrfToken = sha1(random_bytes(9));
        } catch (Exception $e) {
            $this->catchException($e);
        }

        $this->session->set('csrf_token',$csrfToken);

        return $csrfToken;
    }

    public function catchException($e){
        Logger::newMessage($e);
        Logger::customErrorMsg($e);
    }

    public function redirect($status, $url = null) {
        header('Location: ' . host . $url, true, $status);
        exit;
    }

    public function halt($status = 404, $message = 'Something went wrong.') {
        if (ob_get_level() !== 0) {
            ob_clean();
        }

        http_response_code($status);
        $data['status'] = $status;
        $data['message'] = $message;

        // TODO: Change internal View to Twig Engine

        if (!file_exists("/templates/error/$status.php")) {
            $status = 'default';
        }
        require project_root."/templates/error/$status.php";

        exit;
    }

    //abstract function index(Request $request, $get = false);

}
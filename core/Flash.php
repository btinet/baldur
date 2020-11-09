<?php


namespace Core;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Flash
{

    protected $view;

    function __construct($view){

        $this->view = $view;

    }

    public function show($message = false, $type = false) {

        $message = $message ? $message : Session::get('message');
        $type = $type ? $type : Session::get('message_type');
        $type = $type ? $type : 'success';

        if ($message) {
            try {
                echo $this->view->render('/messages/message.html.twig',[
                    'type' => $type,
                    'message' => $message
                ]);
            } catch (LoaderError $e) {
                Logger::newMessage($e);
                Logger::customErrorMsg($e);
            } catch (RuntimeError $e) {
                Logger::newMessage($e);
                Logger::customErrorMsg($e);
            } catch (SyntaxError $e) {
                Logger::newMessage($e);
                Logger::customErrorMsg($e);
            }
            Session::clear('message');
            Session::clear('message_type');
        }
    }

    public function add($message = false, $type = 'success') {

        Session::set('message', $message);
        Session::set('message_type', $type);
        return false;
    }

}
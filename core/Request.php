<?php


namespace Core;


class Request
{
    public $isPostRequest;
    public $query;

    public function __construct(){

    }

    /**
     * @return bool
     */
    public function isPostRequest()
    {
        $this->isPostRequest = (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST');
        return $this->isPostRequest;
    }

    /**
     * @param $FormFieldName
     * @return mixed
     */
    public function getQuery($FormFieldName)
    {
        $this->query = filter_input(INPUT_POST, $FormFieldName, FILTER_SANITIZE_SPECIAL_CHARS);
        return $this->query;
    }

}
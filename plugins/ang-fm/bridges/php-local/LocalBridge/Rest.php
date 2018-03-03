<?php
namespace AngularFilemanager\LocalBridge;

/**
 * REST class
 *
 * For server side REST API implementation (POST, GET, PUT, DELETE as CRUD)
 * Chaineable
 * @author Jakub Ďuraš <jakub@duras.me>
 */
class Rest
{
    /**
     * List of callbacks which are assigned and later called in handle method: post, get, put, delete, before and after
     * @var array
     */
    private $callbacks = array();

    /**
     * @var boolean
     */
    private $requireAuthentication = false;

    /**
     * Add callback for specific HTTP method (post, get, put, delete)
     * @param  string $method    name of the HTTP method
     * @param  array  $arguments expects only one argument, callback, with number of arguments based on request method ($queries, $body['data'], $body['files'])
     * @return object            this
     */
    public function __call($method, $arguments)
    {
        $available_methods = array('post', 'get', 'put', 'delete');
        if (!in_array($method, $available_methods)) {
            throw new Exception('REST method "'.$method.'" not supported.');
        }
        $this->callbacks[$method] = $arguments[0];

        return $this;
    }

    /**
     * moja funkcja
     */
    public function call_override($method, $arguments) {
        $available_methods = array('post', 'get', 'put', 'delete');
        if (!in_array($method, $available_methods)) {
            throw new Exception('REST method "'.$method.'" not supported.');
        }
        $this->callbacks[$method] = $arguments[0];

        return $this;
    }

    /**
     * Should authentication be required
     * @param boolean $option defaults to true
     */
    public function setRequireAuthentication($option = true)
    {
        $this->requireAuthentication = $option;

        return $this;
    }

    /**
     * Add callback called before every request
     * @param  callable $callback arguments: $queries, $body['data'], $body['files']
     * @return object this
     */
    public function before($callback)
    {
        $this->callbacks['before'] = $callback;

        return $this;
    }

    /**
     * Add callback called after every request
     * @param  callable $callback arguments: $queries, $body['data'], $body['files']
     * @return object this
     */
    public function after($callback)
    {
        $this->callbacks['after'] = $callback;

        return $this;
    }

    /**
     * Should be called manually as last method
     */
    public function handle()
    {
        if ($this->requireAuthentication) {
            $authenticateResponse = $this->verifyAuthentication();
            if ($authenticateResponse instanceof Response) {
                $this->respond($response);
                return;
            }
        }

        $request_method = $_SERVER['REQUEST_METHOD'];

        $body = array(
            'data' => null,
            'files' => array()
        );
        $queries = array();
        $parameters = array();

        //Get body data and files only from requests with body
        if ($request_method == 'POST' || $request_method == 'PUT') {
            $body = $this->parseBody();
        }

        if (isset($_GET)) {
            $queries = $_GET;
        }

        if (isset($this->callbacks['before'])) {
            $function = $this->callbacks['before'];
            $function($queries, $body['data'], $body['files']);
        }

        switch ($request_method) {
            case 'POST':
                $function = $this->callbacks['post'];
                $params = array($queries, $body['data'], $body['files']);
                $response = call_user_func_array($function, $params);
                $this->callbacks[$function] = $params[0];
                break;

            case 'GET':
                $function = $this->callbacks['get'];
                $params = array($queries);
                $response = call_user_func_array($function, $params);
                $this->callbacks[$function] = $params[0];
                break;

            case 'PUT':
                $function = $this->callbacks['put'];
                $params = array($queries, $body['data'], $body['files']);
                $response = call_user_func_array($function, $params);
                $this->callbacks[$function] = $params[0];
                break;

            case 'DELETE':
                $function = $this->callbacks['delete'];
                $params = array($queries);
                $response = call_user_func_array($function, $params);
                $this->callbacks[$function] = $params[0];
                break;

            default:
                //Not supported
                $response = new Response();
                $response->setStatus(501, 'Not Implemented');
                break;
        }

        if (isset($this->callbacks['after'])) {
            $function = $this->callbacks['after'];
            $params = array($queries, $body['data'], $body['files']);
            call_user_func_array($function, $params);
            $this->callbacks[$function] = $params[0];
        }

        $this->respond($response);
    }

    /**
     * Uses _POST and _FILES superglobals if available,
     * otherwise tries to parse JSON body if Content Type header is set to application/json,
     * otherwise manually parses body as form data
     * @return array associative array with data and files ['data' => ?, 'files' => ?]
     */
    private function parseBody()
    {
        $data = null;
        $files = null;

        if (isset($_POST) && !empty($_POST)) {
            $data = $_POST;
        }

        if (isset($_FILES) && !empty($_FILES)) {
            $files = $_FILES;
        }

        //In case of request with json body
        if ($data === null) {
            if (isset($_SERVER["CONTENT_TYPE"]) && strpos($_SERVER["CONTENT_TYPE"], 'application/json') !== false) {
                $input = file_get_contents('php://input');

                $data = json_decode($input, true);
            }
        }

        $return_array = array(
            'data' => $data,
            'files' => $files
        );
        return $return_array;
    }

    /**
     * Check wheter client is authorized and returns Response object with autorization request if not
     * @return mixed Response object if client is not authorized, otherwise nothing
     */
    private function verifyAuthentication()
    {
        $authenticated = false;
        $headers = getallheaders();

        if (isset($headers['Authorization'])) {
            $token = str_replace('Token ', '', $headers['Authorization']);

            $authenticated = token::verify($token);
        }

        if ($authenticated === false) {
            $response = new Response();
            $response->setStatus(401, 'Unauthorized')
                     ->addHeaders('WWW-Authenticate: Token');

            return $response;
        }
    }

    /**
        * Use Response object to modify headers and output body
        * @param  Response $response
        */
    private function respond(Response $response)
    {
        foreach ($response->getHeaders() as $header) {
            header($header);
        }

        echo $response->getBody();
    }
}

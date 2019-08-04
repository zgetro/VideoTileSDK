<?php

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\StreamInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;

class VideoTile
{
    private $_client = null;
    private $_endpoint = null;
    private $_adminToken = '';

    /**
     * VideoTileAPI constructor.
     * @param string $endpoint The full URL to the API.
     * @param string $adminToken Private admin token used for authorization on the API endpoint.
     */
    public function __construct($endpoint, $adminToken)
    {
        $this->_endpoint = $endpoint;
        $this->_adminToken = $adminToken;

        $this->_client = new GuzzleClient([
            'http_errors' => false
        ]);
    }

    /**
     * Returns a JSON array of all the courses stored with VideoTile.
     *
     * @return StreamInterface
     * @throws GuzzleException
     */
    public function getCourses()
    {
        return $this->request('POST', 'courses');
    }

    /**
     * Returns a JSON array of a specific course stored with VideoTile.
     *
     * @param integer $courseId
     * @return StreamInterface
     * @throws GuzzleException
     */
    public function getCourseById($courseId)
    {
        return $this->request('POST', 'courses/' . $courseId);
    }

    /**
     * Returns a JSON array of a all courses associated with a user.
     *
     * @param string $token User associated API token, required for authorization
     * @return StreamInterface
     * @throws GuzzleException
     */
    public function getMyCourses($token)
    {
        return $this->request('POST', 'my/courses', [
            'form_params' => [
                'api_token' => $token
            ]
        ]);
    }

    /**
     * Returns a JSON array of all users associated with VideoTile.
     *
     * @return false|StreamInterface|string
     * @throws GuzzleException
     */
    public function getUserList()
    {
        return $this->request('POST', 'admin/users/list', [
            'form_params' => [
                'admin_token' => $this->_adminToken
            ]
        ]);
    }

    /**
     * Returns a JSON object of a user.
     *
     * @param $userId
     * @return false|StreamInterface|string
     * @throws GuzzleException
     */
    public function getUserById($userId)
    {
        return $this->request('POST', 'admin/users/user/' . $userId, [
            'form_params' => [
                'admin_token' => $this->_adminToken
            ]
        ]);
    }

    /**
     * Returns an array of all courses associated to a user.
     *
     * @param integer $userId
     * @return false|StreamInterface|string
     * @throws GuzzleException
     */
    public function getUserCoursesById($userId)
    {
        return $this->request('POST', 'admin/users/user/' . $userId . '/courses', [
            'form_params' => [
                'admin_token' =>  $this->_adminToken
            ]
        ]);
    }

    /**
     * Returns a user object, course object and user course object.
     *
     * @param integer $userId Id of the user to preform the action on.
     * @param integer $courseId Id of the course.
     * @return StreamInterface
     * @throws GuzzleException
     */
    public function getUserCourseByCourseId($userId, $courseId)
    {
        return $this->request('POST', 'admin/users/user/' . $userId . '/courses/' . $courseId, [
            'form_params' => [
                'admin_token' => $this->_adminToken
            ]
        ]);
    }

    /**
     * Returns a status code.
     *
     * @param integer $userId Id of the user to preform the action on.
     * @return StreamInterface
     * @throws GuzzleException
     */
    public function disableUserAccountById($userId)
    {
        return $this->request('POST', 'admin/users/user/' . $userId . '/disable', [
            'form_params' => [
                'admin_token' => $this->_adminToken
            ]
        ]);
    }

    /**
     * Returns a status code.
     *
     * @param string $token A users API token
     * @return StreamInterface
     * @throws GuzzleException
     */
    public function generateAuthToken($token)
    {
        return $this->request('POST', 'my/lms-login', [
            'form_params' => [
                'api_token' => $token
            ]
        ]);
    }

    /**
     * @param string $verb HTTP Verb (POST, GET, PUT, PATCH, DELETE)
     * @param string $resource The API resource we're sending a request to.
     * @param array $parameters An array of parameters for the request.
     * @return false|StreamInterface|string
     * @throws GuzzleException
     */
    private function request($verb, $resource, $parameters = [])
    {
        header('Content-Type: application/json');

        try {
            $response = $this->_client->request($verb, ($this->_endpoint . '/' . $resource), $parameters);

            return $response->getBody();
        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());

            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }
    }
}

<?php

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\StreamInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;

/**
 * Class VideoTile
 * Created by Wish Agency Ltd
 */
class VideoTile
{
    /**
     * @var string $_client GuzzleClient, this is self assigned
     * @var string $_endpoint VideoTile API endpoint
     * @var string $_adminToken The admin token used for admin actions
     * @var string $_vendor The vendor name this is used for the API middleware to determine the request
     */
    private $_client,
        $_endpoint,
        $_adminToken,
        $_vendor = null;

    /**
     * VideoTileAPI constructor.
     * @param string $endpoint The full URL to the API.
     * @param string $adminToken Private admin token used for authorization on the API endpoint.
     * @param string $vendor
     */
    public function __construct($endpoint, $adminToken, $vendor)
    {
        $this->_endpoint = $endpoint;
        $this->_adminToken = $adminToken;
        $this->_vendor = $vendor;

        $this->_client = new GuzzleClient([
            'http_errors' => false
        ]);
    }

    /**
     * Generates a one click link for a user, allows them to login instantly to VideoTile.
     *
     * @param string $token A users `api_token`
     * @param string $action The action we'd like the user to go through (course or suite)
     * @param int $actionId If specified, a course id
     * @return string An error or a built up login URL.
     * @throws GuzzleException
     */
    public function generateLoginUrl($token, $action = 'course', $actionId = 0)
    {
        $authToken = null;

        /* use a below method for generating the auth token */
        $getAuthToken = $this->generateAuthToken($token);

        /* providing we get a request, let's dig in further */
        if (!empty($getAuthToken)) {
            $authTokenData = \GuzzleHttp\json_decode($getAuthToken, true);

            /* If we have an error, throw it */
            if (isset($authTokenData['error'])) {
                return $authTokenData['error'];
            }

            /* Retrieve the token and return a built up script */
            $authToken = $authTokenData['auth_token'];

            return 'https://videotilehost.com/' . $this->_vendor . '/api_script.php?vendor=' . $this->_vendor . '&token=' . $authToken . '&action=' . $action . '&id=' . $actionId;
        }

        return 'No token could be found';
    }

    /**
     * Authenticates a user, this is used to return an `api_token` from the API for first-time usage.
     *
     * @param string $username Username from the LMS panel.
     * @param string $password The users password.
     * @return false|StreamInterface|string
     * @throws GuzzleException
     */
    public function authenticateUser($username, $password)
    {
        return $this->request('POST', 'login', [
            'form_params' => [
                'username' => $username,
                'password' => $password
            ]
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
     * Creates a user in the VideoTile LMS
     *
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $telephone
     * @return false|StreamInterface|string
     * @throws GuzzleException
     */
    public function createUser($firstName, $lastName, $email, $telephone)
    {
        return $this->request('POST', 'admin/users/create', [
            'form_params' => [
                'admin_token' => $this->_adminToken,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'telephone' => $telephone,
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
                'admin_token' => $this->_adminToken,
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
                'admin_token' => $this->_adminToken
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
     * @param integer $userId Id of the user to preform the action on.
     * @return StreamInterface
     * @throws GuzzleException
     */
    public function enableUserAccountById($userId)
    {
        return $this->request('POST', 'admin/users/user/' . $userId . '/enable', [
            'form_params' => [
                'admin_token' => $this->_adminToken
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
            /* append the vendor id, instead of assigning it to every method above */
            if (!isset($parameters['form_params']['vendor_id'])) {
                $parameters['form_params']['vendor_id'] = $this->_vendor;
            }

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

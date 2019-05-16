<?php

use \GuzzleHttp\Client as GuzzleClient;

class VideoTile
{
    private $client = null;
    private $endpoint = null;

    /**
     * VideoTileAPI constructor.
     * @param $endpoint
     */
    public function __construct($endpoint)
    {
        $this->endpoint = $endpoint;

        $this->client = new GuzzleClient([
            'http_errors' => false
        ]);
    }

    /**
     * Returns a JSON array of all the courses stored with VideoTile.
     *
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCourses()
    {
        return $this->request('POST', '/courses');
    }

    /**
     * Returns a JSON array of a specific course stored with VideoTile.
     *
     * @param integer $courseId
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCourseById($courseId)
    {
        return $this->request('POST', '/courses/' . $courseId);
    }

    /**
     * Returns a JSON array of a all courses associated with a user.
     *
     * @param string $token User associated API token, required for authorization
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
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
     * @param string $token User associated API token, required for authorization
     * @return false|\Psr\Http\Message\StreamInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserList($token)
    {
        return $this->request('POST', 'admin/users/list', [
            'form_params' => [
                'admin_token' => $token
            ]
        ]);
    }

    /**
     * Returns a JSON object of a user.
     *
     * @param string $token User associated API token, required for authorization
     * @param $userId
     * @return false|\Psr\Http\Message\StreamInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserById($token, $userId)
    {
        return $this->request('POST', 'admin/users/user/' . $userId, [
            'form_params' => [
                'admin_token' => $token
            ]
        ]);
    }

    /**
     * Returns an array of all courses associated to a user.
     *
     * @param string $token User associated API token, required for authorization
     * @param integer $userId
     * @return false|\Psr\Http\Message\StreamInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserCoursesById($token, $userId)
    {
        return $this->request('POST', 'admin/users/user/' . $userId . '/courses', [
            'form_params' => [
                'admin_token' => $token
            ]
        ]);
    }

    /**
     * Returns a user object, course object and user course object.
     *
     * @param string $token Admin API token, required for authorization
     * @param integer $userId
     * @param integer $courseId
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserCourseByCourseId($token, $userId, $courseId)
    {
        return $this->request('POST', 'admin/users/user/' . $userId . '/courses/' . $courseId, [
            'form_params' => [
                'admin_token' => $token
            ]
        ]);
    }

    /**
     * Returns a status code.
     *
     * @param string $token
     * @param integer $userId
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function disableUserAccountById($token, $userId)
    {
        return $this->request('POST', 'admin/users/user/' . $userId . '/disable', [
            'form_params' => [
                'admin_token' => $token
            ]
        ]);
    }

    /**
     * @param integer $status
     * @param string $endPoint
     * @param array $parameters
     * @return false|\Psr\Http\Message\StreamInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function request($status, $endPoint, $parameters = [])
    {
        header('Content-Type: application/json');

        $response = $this->client->request($status, $this->endpoint . '/' . $endPoint, $parameters);

        $status = $response->getStatusCode();

        if ($status == 200) {
            return $response->getBody();
        }

        return json_encode([
            'error' => 'soething'
        ]);
    }
}
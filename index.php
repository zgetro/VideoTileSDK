<?php

class VideoTileAPI
{
    private $client = null;
    private $endpoint = null;

    public function __construct($endpoint)
    {
        $this->endpoint = $endpoint;
        $this->client = new \GuzzleHttp\Client(['http_errors' => false]);
    }

    public function getUser($userId)
    {
        $response = $this->client->request('GET', $this->endpoint . '/users/' . $userId);

        return $response->getBody();
    }

    public function getUserCourses($userId)
    {
        $response = $this->client->request('GET', $this->endpoint . '/users/' . $userId . '/courses');

        return $response->getBody();
    }

    public function getUserCourse($userId, $courseId)
    {
        $response = $this->client->request('GET', $this->endpoint . '/users/' . $userId . '/courses/' . $courseId);

        return $response->getBody();
    }

    public function getUserCourseProgression($userId, $courseId)
    {
        $data = json_decode($this->getUserCourse($userId, $courseId), true);

        return json_encode(['percentage' => $data['course']['percentage']]);
    }

    public function getUsers()
    {
        $response = $this->client->request('GET', $this->endpoint . '/users');

        return $response->getBody();
    }

    public function getCourse($courseId)
    {
        $response = $this->client->request('GET', $this->endpoint . '/courses/' . $courseId);

        return $response->getBody();
    }

    public function getCourses()
    {
        $response = $this->client->request('GET', $this->endpoint . '/courses');

        return $response->getBody();
    }
}

<?php

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use VideoTileSdk\VideoTile;

class VideoTileTest extends TestCase
{
    private $videoTile;
    private $mockClient;

    protected function setUp(): void
    {
        $this->mockClient = $this->createMock(GuzzleClient::class);
        $this->videoTile = new VideoTile('https://fake.endpoint', 'admin_token', 'vendor', $this->mockClient);
    }

    public function testAuthenticateUser()
    {
        $this->mockClient->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://fake.endpoint/login',
                [
                    'form_params' => [
                        'email'     => 'test@example.com',
                        'password'  => 'password',
                        'vendor_id' => 'vendor',
                    ],
                ]
            )
            ->willReturn(new Response(200, [], 'token'));

        $result = $this->videoTile->authenticateUser('test@example.com', 'password');
        $this->assertEquals('token', (string) $result);
    }

    public function testGenerateAuthToken()
    {
        $this->mockClient->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://fake.endpoint/my/lms-login',
                [
                    'form_params' => [
                        'api_token' => 'token',
                        'vendor_id' => 'vendor',
                    ],
                ]
            )
            ->willReturn(new Response(200, [], 'auth_token'));

        $result = $this->videoTile->generateAuthToken('token');
        $this->assertEquals('auth_token', (string) $result);
    }

    public function testGetUserList()
    {
        $this->mockClient->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://fake.endpoint/admin/users/list',
                [
                    'form_params' => [
                        'admin_token' => 'admin_token',
                        'vendor_id'   => 'vendor',
                    ],
                ]
            )
            ->willReturn(new Response(200, [], 'user_list'));

        $result = $this->videoTile->getUserList();
        $this->assertEquals('user_list', (string) $result);
    }

    public function testGetUserById()
    {
        $this->mockClient->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://fake.endpoint/admin/users/user/1',
                [
                    'form_params' => [
                        'admin_token' => 'admin_token',
                        'vendor_id'   => 'vendor',
                    ],
                ]
            )
            ->willReturn(new Response(200, [], 'user'));

        $result = $this->videoTile->getUserById(1);
        $this->assertEquals('user', (string) $result);
    }

    public function testCreateUser()
    {
        $this->mockClient->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://fake.endpoint/admin/users/create',
                [
                    'form_params' => [
                        'admin_token' => 'admin_token',
                        'first_name'  => 'John',
                        'last_name'   => 'Doe',
                        'email'       => 'john@example.com',
                        'telephone'   => '1234567890',
                        'vendor_id'   => 'vendor',
                    ],
                ]
            )
            ->willReturn(new Response(200, [], 'created'));

        $result = $this->videoTile->createUser('John', 'Doe', 'john@example.com', '1234567890');
        $this->assertEquals('created', (string) $result);
    }

    public function testAssignCourseByUserId()
    {
        $this->mockClient->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://fake.endpoint/admin/course/assign',
                [
                    'form_params' => [
                        'user_id'     => 1,
                        'course_id'   => 2,
                        'admin_token' => 'admin_token',
                        'vendor_id'   => 'vendor',
                    ],
                ]
            )
            ->willReturn(new Response(200, [], 'assigned'));

        $result = $this->videoTile->assignCourseByUserId(1, 2);
        $this->assertEquals('assigned', (string) $result);
    }

    public function testGetUserCoursesById()
    {
        $this->mockClient->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://fake.endpoint/admin/users/user/1/courses',
                [
                    'form_params' => [
                        'admin_token' => 'admin_token',
                        'vendor_id'   => 'vendor',
                    ],
                ]
            )
            ->willReturn(new Response(200, [], 'courses'));

        $result = $this->videoTile->getUserCoursesById(1);
        $this->assertEquals('courses', (string) $result);
    }

    public function testGetUserCourseByCourseId()
    {
        $this->mockClient->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://fake.endpoint/admin/users/user/1/courses/2',
                [
                    'form_params' => [
                        'admin_token' => 'admin_token',
                        'vendor_id'   => 'vendor',
                    ],
                ]
            )
            ->willReturn(new Response(200, [], 'user_course'));

        $result = $this->videoTile->getUserCourseByCourseId(1, 2);
        $this->assertEquals('user_course', (string) $result);
    }

    public function testDisableUserAccountById()
    {
        $this->mockClient->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://fake.endpoint/admin/users/user/1/disable',
                [
                    'form_params' => [
                        'admin_token' => 'admin_token',
                        'vendor_id'   => 'vendor',
                    ],
                ]
            )
            ->willReturn(new Response(200, [], 'disabled'));

        $result = $this->videoTile->disableUserAccountById(1);
        $this->assertEquals('disabled', (string) $result);
    }

    public function testEnableUserAccountById()
    {
        $this->mockClient->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://fake.endpoint/admin/users/user/1/enable',
                [
                    'form_params' => [
                        'admin_token' => 'admin_token',
                        'vendor_id'   => 'vendor',
                    ],
                ]
            )
            ->willReturn(new Response(200, [], 'enabled'));

        $result = $this->videoTile->enableUserAccountById(1);
        $this->assertEquals('enabled', (string) $result);
    }

    public function testGetCourses()
    {
        $this->mockClient->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://fake.endpoint/courses',
                [
                    'form_params' => [
                        'vendor_id' => 'vendor',
                    ],
                ]
            )
            ->willReturn(new Response(200, [], 'courses'));

        $result = $this->videoTile->getCourses();
        $this->assertEquals('courses', (string) $result);
    }

    public function testGetCourseById()
    {
        $this->mockClient->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://fake.endpoint/courses/1',
                [
                    'form_params' => [
                        'vendor_id' => 'vendor',
                    ],
                ]
            )
            ->willReturn(new Response(200, [], 'course'));

        $result = $this->videoTile->getCourseById(1);
        $this->assertEquals('course', (string) $result);
    }

    public function testGetMyCourses()
    {
        $this->mockClient->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://fake.endpoint/my/courses',
                [
                    'form_params' => [
                        'api_token' => 'token',
                        'vendor_id' => 'vendor',
                    ],
                ]
            )
            ->willReturn(new Response(200, [], 'my_courses'));

        $result = $this->videoTile->getMyCourses('token');
        $this->assertEquals('my_courses', (string) $result);
    }

    public function testGenerateLoginUrlError()
    {
        $mock = $this->getMockBuilder(VideoTile::class)
            ->setConstructorArgs(['https://fake.endpoint', 'admin_token', 'vendor', $this->mockClient])
            ->onlyMethods(['generateAuthToken'])
            ->getMock();
        $mock->expects($this->once())
            ->method('generateAuthToken')
            ->with('token')
            ->willReturn(json_encode(['error' => 'Invalid token']));

        $result = $mock->generateLoginUrl('token');
        $this->assertEquals('Invalid token', $result);
    }

    public function testGenerateLoginUrlSuccess()
    {
        $mock = $this->getMockBuilder(VideoTile::class)
            ->setConstructorArgs(['https://fake.endpoint', 'admin_token', 'vendor', $this->mockClient])
            ->onlyMethods(['generateAuthToken'])
            ->getMock();
        $mock->expects($this->once())
            ->method('generateAuthToken')
            ->with('token')
            ->willReturn(json_encode(['auth_token' => 'abc123']));

        $result = $mock->generateLoginUrl('token', 'course', 55);
        $this->assertStringContainsString('https://videotilehost.com/vendor/api_script.php?vendor=vendor&token=abc123&action=course&id=55', $result);
    }
}

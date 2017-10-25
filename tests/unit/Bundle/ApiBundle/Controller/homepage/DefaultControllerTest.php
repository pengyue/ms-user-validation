<?php

namespace PengYue\UserValidation\Bundle\ApiBundle\Controller\homepage;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultControllerTest extends TestCase
{
    public function testItCanGetServiceDescription()
    {
        $controller = new DefaultController();
        $response = JsonResponse::create([
            'meta' => 'Q-Platform user validation microservice',
            'links' => [
                'self' => '/',
                'homepage' => [
                    'link' => '/',
                    'meta' => ['version' => '1'],
                ],
                'api_v1' => [
                    'link' => '/api/v1/ping',
                    'meta' => ['version' => '1'],
                ],
                'api_v2' => [
                    'link' => '/api/v2/ping',
                    'meta' => ['version' => '2'],
                ]
            ]
        ]);
        $this->assertEquals($response, $controller->indexAction());
    }
}
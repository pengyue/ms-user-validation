<?php

namespace PengYue\UserValidation\Bundle\ApiBundle\Controller\v1;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultControllerTest extends TestCase
{
    public function testItCanGetServiceStatus()
    {
        $controller = new DefaultController();
        $response = JsonResponse::create(['status' => 'OK']);
        $this->assertEquals($response, $controller->getStatusAction());
    }
}
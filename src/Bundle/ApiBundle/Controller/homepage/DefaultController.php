<?php

namespace PengYue\UserValidation\Bundle\ApiBundle\Controller\homepage;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Description of DefaultController
 */
class DefaultController extends Controller
{
    public function indexAction()
    {
        return new JsonResponse(
            [
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
            ]
        );
    }

}
<?php

namespace PengYue\UserValidation\Bundle\ApiBundle\Controller\v2;

use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController
{
    public function getStatusAction()
    {
        return new JsonResponse(
            ['status' => 'OK']
        );
    }
}
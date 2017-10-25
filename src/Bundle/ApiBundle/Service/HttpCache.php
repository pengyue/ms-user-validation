<?php

namespace PengYue\UserValidation\Bundle\ApiBundle\Service;

use Symfony\Component\HttpFoundation\Response;

class HttpCache
{
    /**
     * @var \DateTime
     */
    private $createTime;

    public function __construct()
    {
        $this->createTime = new \DateTime('now', new \DateTimeZone('UTC'));
    }

    /**
     * Set the http response cache
     *
     * @param Response $response
     * @param int $maxAge
     * @param mixed $eTag
     */
    public function setCache(Response $response, $maxAge = 60, $eTag = null)
    {
        $response->setCache([
            'etag'          => null === $eTag ?  md5(bin2hex(random_bytes(8))) : md5($eTag),
            'last_modified' => $this->createTime,
            'max_age'       => $maxAge,
            'private'       => false,
            'public'        => true,
        ]);
    }
}
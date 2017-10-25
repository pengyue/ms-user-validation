<?php

namespace PengYue\UserValidation\Bundle\ApiBundle;

use PengYue\UserValidation\Bundle\ApiBundle\DependencyInjection\ApiExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Description of BaseApiBundle
 */
class ApiBundle extends Bundle
{

    /**
     * @var string
     */
    protected $name = 'ApiBundle';

    /**
     * @return string
     */
    public function getPath()
    {
        return __DIR__;
    }

    /**
     * @return ExtensionInterface
     */
    public function getContainerExtension()
    {
        if ($this->extension === null) {
            $this->extension = new ApiExtension();
        }

        return $this->extension;
    }

    /**
     * @return string
     */
    public function getContainerExtensionClass()
    {
        return ApiExtension::class;
    }

}

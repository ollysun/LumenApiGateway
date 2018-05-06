<?php
namespace App\Providers\Service;

use App\Providers\Service\Contract\ServiceContract;
use App\Providers\Service\Contract\Service as ConfigService;

class Service implements ServiceContract
{
    public function getService(string $serviceKey) : ConfigService
    {
        $services = [];

        foreach (new \DirectoryIterator(base_path(config('gateway.service.dir'))) as $fileinfo) {
            if (!$fileinfo->isDot()) {
                if (!$fileinfo->isFile() || substr($fileinfo->getFilename(), 0, 1) == '.') {
                    continue;
                }

                if (preg_match(sprintf("/^(?<class>.*).%s$/", $fileinfo->getExtension()), $fileinfo->getFilename(), $matches)) {
                    $serviceClass = sprintf(
                        "%s\%s",
                        config('gateway.service.namespace'),
                        $matches['class']
                    );

                    $service = new $serviceClass();

                    if ($service instanceof ConfigService) {
                        if (array_key_exists($service->getServiceKey(), $services)) {
                            throw new \Exception(sprintf("The service key already exist: %s", $service->getServiceKey()));
                        }
        
                        $services[$service->getServiceKey()] = $service;
                    }
                }
            }
        }

        if (array_key_exists($serviceKey, $services)) {
            return $services[$serviceKey];
        }

        throw new ServiceNotFound();
    }
}

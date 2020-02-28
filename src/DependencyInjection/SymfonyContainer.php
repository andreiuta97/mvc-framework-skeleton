<?php
declare(strict_types=1);

namespace Framework\DependencyInjection;

use Framework\Contracts\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as SymfonyContainerInterface;

class SymfonyContainer implements ContainerInterface
{
    /**
     * @var SymfonyContainerInterface
     */
    private $container;

    /**
     * @param SymfonyContainerInterface $container
     */
    public function __construct(SymfonyContainerInterface $container)
    {
        $this->container = $container;
    }

    public function set(string $id, ?object $service)
    {
        return $this->container->set($id, $service);
    }

    public function get($id)
    {
        return $this->container->get($id);
    }

    public function has($id)
    {
        return $this->container->has($id);
    }
}

<?php

declare(strict_types=1);

namespace App;

use Nyholm\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class Kernel
{
    private $booted = false;
    private $debug;
    private $environment;

    /** @var Container */
    private $container;

    public function __construct(string $env, bool $debug = false)
    {
        $this->debug = $debug;
    }

    /**
     * Handle a Request and turn it in to a response.
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        $this->boot();

        $middlewares[] = new \App\Middleware\Cache();
        $middlewares[] = new \App\Middleware\Router();

        $runner = (new \Relay\RelayBuilder())->newInstance($middlewares);

        return $runner($request, new Response());
    }

    public function boot()
    {
        if ($this->booted) {
            return;
        }

        $containerDumpFile = __DIR__.'/../var/cache/container.php';
        if (!$this->debug && file_exists($containerDumpFile)) {
            require_once $containerDumpFile;
            $container = new CachedContainer();
        } else {
            $container = new ContainerBuilder();
            $container->setParameter('root_dir', dirname(__DIR__));
            $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../app/'));
            $loader->load('services.yml');

            if ($this->debug) {
                $container->setAlias('cache', 'cache.void');
            }

            $container->compile();

            if (!$this->debug) {
                //dump the container
                $dumper = new PhpDumper($container);
                file_put_contents($containerDumpFile, $dumper->dump(array('class' => 'CachedContainer')));
            }
        }

        $this->container = $container;

        $this->booted = true;
    }
}
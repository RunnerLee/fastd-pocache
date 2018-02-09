<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2018-02
 */

namespace Runner\Pocache;

use FastD\Container\Container;
use FastD\Container\ServiceProviderInterface;
use FastD\Http\Response;
use FastD\Http\ServerRequest;
use Runner\Pocache\Command\Clear;

class FastdPocacheServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $container
     *
     * @return mixed
     */
    public function register(Container $container)
    {
        route()->post('/flush_opcache', function (ServerRequest $request) {
            if (
                $request->getParam('token', '') !== config()->get('opcache.flush_token')
                || !function_exists('opcache_reset')
            ) {
                return new Response('', Response::HTTP_NO_CONTENT);
            }

            opcache_reset();

            return new Response('ok', Response::HTTP_OK);
        });

        config()->merge([
            'consoles' => [
                Clear::class,
            ],
        ]);
    }
}

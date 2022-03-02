<?php


namespace Catt\AuthNode\Middleware;


use Catt\AuthNode\Contract\AuthNodeInterface;
use Hyperf\HttpServer\Router\Dispatched;
use Hyperf\Utils\ApplicationContext;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthNodeMiddleware implements MiddlewareInterface {

    public function process (ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {

        $dispatched = $request->getAttribute(Dispatched::class);

        if (is_null($dispatched->handler)) {
            return $handler->handle($request);
        }

        $container = ApplicationContext::getContainer();

        $AuthNodeHandler = $container->get(AuthNodeInterface::class);

        $class  = $dispatched->handler->callback[0];
        $method = $dispatched->handler->callback[1];

        $authNodeList = [
            $AuthNodeHandler->getClassNode($class),
            $AuthNodeHandler->getMethodNode($class, $method),
        ];

        $request = $request->withAttribute(\Catt\AuthNode\Object\CurrentNode::class, $authNodeList);

        return $handler->handle($request);
    }
}

<?php


namespace Catt\AuthNode;


use Catt\AuthNode\Handler\AuthNodeHandler;
use Hyperf\Utils\ApplicationContext;

class AuthNodeFactory {

    public function __invoke () {
        return ApplicationContext::getContainer()->get(AuthNodeHandler::class);
    }

}

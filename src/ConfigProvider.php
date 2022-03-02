<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace Catt\AuthNode;

use Catt\AuthNode\Contract\AuthNodeInterface;
use Catt\AuthNode\Listener\RegisterAuthNodeListener;

class ConfigProvider {
    public function __invoke (): array {
        return [
            'dependencies' => [
                AuthNodeInterface::class => AuthNodeFactory::class,
            ],
            'commands'     => [],
            'listeners'    => [
                RegisterAuthNodeListener::class,
            ],
            'annotations'  => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
        ];
    }
}

<?php


namespace Catt\AuthNode\Contract;


use Catt\AuthNode\Object\CurrentNode;

interface AuthNodeInterface {

    public function hasNode (string $fullNode): bool;

    public function addNode (CurrentNode $data);

    public function getClassNode (string $class);

    public function getMethodNode (string $class, string $method);

    public function getNodeList (): array;

}

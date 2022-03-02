<?php


namespace Catt\AuthNode\Handler;


use Catt\AuthNode\Contract\AuthNodeInterface;
use Catt\AuthNode\Object\CurrentNode;
use Hyperf\Utils\Arr;
use Hyperf\Utils\Collection;

class AuthNodeHandler implements AuthNodeInterface {

    protected $node_list = [];

    protected $class_node_list = [];

    protected $method_node_list = [];

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasNode (string $name): bool {
        return Arr::exists($this->node_list, $name);
    }

    /**
     * @param CurrentNode $node
     *
     * @throws \Exception
     * @internal
     */
    public function addNode (CurrentNode $node) {

        if (is_null($node->getName())) {
            throw new \Exception('节点名称为空');
        }

        if ($this->hasNode($node->getName())) {
            throw new \Exception(sprintf('节点名称[%s]重复', $node->getName()));
        }

        $this->node_list[$node->getName()] = $node;

        if ($node->classNode && !$node->methodNode) {
            $this->class_node_list[$node->class] = $node;
        }

        if ($node->methodNode) {
            $this->method_node_list[$node->class.'::'.$node->method] = $node;
        }

    }

    /**
     * @param string $class
     *
     * @return mixed|null
     */
    public function getClassNode (string $class) {

        if (array_key_exists($class, $this->class_node_list)) {
            return $this->class_node_list[$class];
        }

        return null;
    }

    /**
     * @param string $class
     * @param string $method
     *
     * @return mixed|null
     */
    public function getMethodNode (string $class, string $method) {

        if (array_key_exists($class.'::'.$method, $this->method_node_list)) {
            return $this->method_node_list[$class.'::'.$method];
        }

        return null;
    }

    /**
     * 获取节点列表
     *
     * @return array
     */
    public function getNodeList (): array {
        return $this->node_list;
    }

}

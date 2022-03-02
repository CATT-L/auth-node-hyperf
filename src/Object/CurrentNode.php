<?php


namespace Catt\AuthNode\Object;


use Hyperf\Utils\Contracts\Arrayable;

class CurrentNode implements Arrayable {

    /**
     * @var string|null
     */
    public $class;

    /**
     * @var string|null
     */
    public $method = null;

    /**
     * @var \Catt\AuthNode\Annotation\IsAuthNode|null
     */
    public $classNode = null;

    /**
     * @var \Catt\AuthNode\Annotation\IsAuthNode|null
     */
    public $methodNode = null;

    /**
     * @var null|string
     */
    protected $name = null;

    /**
     * @var null|string
     */
    protected $label = null;


    public function getName () {

        if (!is_null($this->name)) {
            return $this->name ?: null;
        }

        $class = $this->class;
        if ($this->classNode) {
            $class = $this->classNode->name ?: $this->class;
        }

        $method = $this->method;
        if ($this->methodNode) {
            $method = $this->methodNode->name ?: $this->method;
        }

        $full = [];

        !empty($class) && array_push($full, $class);
        !empty($method) && array_push($full, $method);

        $this->name = empty($full) ? null : join('::', $full);

        return $this->getName();
    }

    public function getLabel () {

        if (!is_null($this->label)) {
            return $this->label ?: null;
        }

        $class = null;
        if ($this->classNode) {
            $class = $this->classNode->label;
        }

        $method = null;
        if ($this->methodNode) {
            $method = $this->methodNode->label;
        }

        $full = [];

        !empty($class) && array_push($full, $class);
        !empty($method) && array_push($full, $method);

        $this->label = empty($full) ? '' : join('::', $full);

        return $this->getLabel();
    }

    public function toArray (): array {
        return [
            'name'       => $this->getName(),
            'label'      => $this->getLabel(),
            'class'      => $this->class,
            'method'     => $this->method,
            'classNode'  => $this->classNode,
            'methodNode' => $this->methodNode,
        ];
    }
}

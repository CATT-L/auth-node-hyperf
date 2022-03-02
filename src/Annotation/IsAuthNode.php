<?php


namespace Catt\AuthNode\Annotation;

use Hyperf\Di\Annotation\AbstractAnnotation;



/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsAuthNode extends AbstractAnnotation {

    /**
     * 节点名称
     *
     * @var string
     */
    public $name;

    /**
     * 节点备注
     *
     * @var string
     */
    public $label;

}

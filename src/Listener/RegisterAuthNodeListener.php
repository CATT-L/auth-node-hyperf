<?php


namespace Catt\AuthNode\Listener;


use Catt\AuthNode\Annotation\IsAuthNode;
use Catt\AuthNode\Contract\AuthNodeInterface;
use Catt\AuthNode\Object\CurrentNode;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Di\Annotation\AnnotationCollector;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Framework\Event\BootApplication;
use Hyperf\Utils\ApplicationContext;

class RegisterAuthNodeListener implements ListenerInterface {

    public function listen (): array {
        return [
            BootApplication::class,
        ];
    }

    public function process (object $event) {

        $container = ApplicationContext::getContainer();

        $logger  = $container->get(StdoutLoggerInterface::class);
        $handler = $container->get(AuthNodeInterface::class);

        /** @var IsAuthNode $methodNode */
        foreach (AnnotationCollector::getClassesByAnnotation(IsAuthNode::class) as $class => $classNode) {

            $node = make(CurrentNode::class);

            $node->class     = $class;
            $node->classNode = $classNode;

            try {
                $handler->addNode($node);
            } catch (\Throwable $th) {
                $logger->warning(sprintf('[AuthNode] %s, 位于:%s', $th->getMessage(), $class));
            }
        }

        foreach (AnnotationCollector::getMethodsByAnnotation(IsAuthNode::class) as $item) {

            $class  = $item['class'];
            $method = $item['method'];

            /** @var IsAuthNode $node */
            $methodNode = $item['annotation'];

            /** @var IsAuthNode $classNode */
            $classNode = AnnotationCollector::getClassAnnotation($class, IsAuthNode::class);

            $node = make(CurrentNode::class);

            $node->class      = $class;
            $node->method     = $method;
            $node->classNode  = $classNode;
            $node->methodNode = $methodNode;

            try {
                $handler->addNode($node);
            } catch (\Throwable $th) {
                $logger->warning(sprintf('[AuthNode] %s, 位于:%s->%s', $th->getMessage(), $class, $method));
            }
        }
    }
}

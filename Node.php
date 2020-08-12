<?php

/**
 * Узел односвязного списка
 */
class Node
{
    /** @var string Значение узла */
    private $nodeValue;

    /** @var Node Ссылка на следующий узел */
    private $nextNode;

    public function __construct(string $nodeValue, ?Node $nextNode = null)
    {
        $this->nodeValue = $nodeValue;
        $this->nextNode = $nextNode;
    }

    public function getNodeValue() : string
    {
        return $this->nodeValue;
    }

    public function getNextNode() : ?Node
    {
        return $this->nextNode;
    }

    public function setNextNode(Node $node) : void
    {
        $this->nextNode = $node;
    }
}

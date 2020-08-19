<?php

/**
 * Узел
 * 
 * Опционально:
 * + Связь с другим узлом
 * + Значение приоритета узла
 */
class Node
{
    /** @var string Значение узла */
    private $nodeValue;

    /** @var Node Ссылка на следующий узел */
    private $nextNode;

    /** @var string $priority Значение приоритета узла */
    protected $priority;

    public function __construct(string $nodeValue, ?Node $nextNode = null, string $priority = null)
    {
        $this->nodeValue = $nodeValue;
        $this->nextNode = $nextNode;
        $this->priority = $priority;
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

    /**
     * Возвращает значение приоритета узла
     *
     * @param void
     * @return string
     **/
    public function getPriority(): string
    {
        return $this->priority;
    }

    /**
     * Меняет приоритет узла
     *
     * @param string $newPriority Новое значение приоритета
     * @return void
     **/
    public function setPriority(string $newPriority): void
    {
        $this->priority = $newPriority;
    }
}

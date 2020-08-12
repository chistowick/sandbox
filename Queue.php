<?php

class Queue
{

    /** @var Node $first Указатель на первый элемент очереди */
    protected $first;

    /** @var Node $last Указатель на последний элемент очереди */
    protected $last;

    public function __construct()
    {
        // Изначально оба указателя смотрят на null
        $this->first = null;
        $this->last = null;
    }

    /**
     * Добавить узел в хвост очереди
     *
     * @param string $value - значение добавляемого узла
     * @return void
     **/
    public function enqueue(string $value)
    {
        // Создать новый элемент
        $newNode = new Node($value);

        // Если очередь пуста, то новый элемент считаем и первым и последним
        if ($this->isEmpty()) {

            $this->first = $newNode;
            $this->last = $newNode;
        } else {

            // Иначе, в последний известный элемент записываем ссылку на новый node 
            $this->last->setNextNode($newNode);

            // И запоминаем новый node как последний элемент
            $this->last = $newNode;
        }
    }

    /**
     * Получить значение first-элемента очереди и удалить его из очереди
     *
     * @param void
     * @return string|null Значение first-элемента очереди - $nodeValue
     **/
    public function dequeue()
    {
        // Если очередь пуста, возвращаем null
        if ($this->isEmpty()) {

            return null;
        } else {
            // Иначе, запоминаем значение из first-элемента
            $firstNodeValue = $this->first->getNodeValue();

            // И станавливаем указатель first на следующий узел (на null, если элемент был последний)
            $this->first = $this->first->getNextNode();

            /**
             * Если после извлечения элемента, $first указывает на null, то есть очередь пуста
             * то обнуляем и указатель на последний элемент (чтобы в $last не висел уже извлеченный элемент)
             */
            if ($this->first === null) {
                $this->last = null;
            }

            /** 
             * Возвращаем сохраненное значение, извлеченное из первого элемента очереди
             * (который, как предполагается, остался уже без ссылок на него и будет удален) 
             */
            return $firstNodeValue;
        }
    }

    /**
     * Проверяет очередь на наличие в ней элементов
     *
     * @param void
     * @return bool - true - очередь пустая, false - не пустая
     **/
    public function isEmpty(): bool
    {
        // Очередь пустая, когда $first был назначен указывать на null
        return ($this->first === null);
    }
}

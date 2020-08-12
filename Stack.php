<?php

class Stack
{
    /** @var Node Указатель на верхний элемент стека */
    private $last;

    public function __construct()
    {
        $this->last = null;
    }

    /**
     * Добавляет в стек новый элемент
     *
     * @param string $value - значение нового элемента
     * @return void
     **/
    public function push(string $value)
    {
        /**
         * Создаем новый Node и запоминаем его как последний
         * 
         * Ссылка на нижележащий узел, который был в $last записывается в новый $last
         * таким образом, объекты Node по очереди указывают друг на друга,
         * нижний Node указывает на null
         */
        $this->last = new Node($value, $this->last);
    }

    /**
     * Возвращает значение $nodeValue верхнего узла
     * 
     * @return string|null Значение верхнего узла стека - $nodeValue
     */
    public function pop(): ?string
    {
        // Если стек пуст возвращаем null
        if ($this->isEmpty()) {
            return null;
        }

        // Получаем значение верхнего узла в $item
        $item = $this->last->getNodeValue();

        /**
         * Перемещаем указатель $last на следующий узел,
         * таким образом, на текущий Node ссылок не должно остаться и он будет удален из памяти
         */
        $this->last = $this->last->getNextNode();

        return $item;
    }

    /**
     * Проверяет стек на наличие в нем элементов
     *
     * @param void
     * @return bool - true - стек пуст, false - не пуст
     **/
    public function isEmpty(): bool
    {
        // Стек пуст, когда $last был назначен указывать на null
        return ($this->last === null);
    }

    /**
     * Получить last-элемент, но не удалять
     *
     * @param void
     * @return object|null Node
     **/
    public function top(): ?object
    {
        return $this->last;
    }
}

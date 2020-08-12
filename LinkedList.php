<?php

abstract class LinkedList
{
    /**
     * Получить top-элемент, но не удалять (элемент, с которого начинается цепочка ссылок)
     *
     * @param void
     * @return object|null Node
     **/
    abstract protected function top(): ?object;

    /**
     * Проверить последовательность на наличие в ней элементов
     *
     * @param void
     * @return bool - true - последовательность пустая, false - не пустая
     **/
    abstract protected function isEmpty(): bool;

    /**
     * Функция - генератор
     * 
     * Получить список значений всех элементов последовательности (список из $nodeValue всех node)
     *
     * @param void
     * @return iterable|void
     **/
    public function getList(): ?iterable
    {
        // Считаем top-узел текущим
        $currentNode = $this->top();

        // Пока в текущем узле не окажется null (то есть пока не пуст стек)
        while ($currentNode !== null) {

            // Возвращаем в место вызова метода значение $nodeValue текущего узла
            yield $currentNode->getNodeValue();

            // Переходим к следующему узлу
            $currentNode = $currentNode->getNextNode();
        }
    }
}

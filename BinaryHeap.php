<?php

/**
 * Двоичная куча или сортирующее дерево
 * 1) Значение в любой вершине больше или равно, значениям её потомков
 * 2) Глубина всех листьев отличается не более чем на 1 слой
 * 3) Последний слой заполняется слева направо без пропусков
 */
class BinaryHeap
{
    /**
     * Восстановление свойств кучи
     * 
     * @param int $index
     * @return void
     **/
    public function heapify(int $index)
    {
        # code...
    }

    /**
     * Построение кучи
     *
     * @param void
     * @return 
     **/
    public function buildHeap()
    {
        # code...
    }

    /**
     * Изменение значения элемента
     *
     * @param int $index Индекс элемента, приоритет которого нужно увеличить в max-heap
     * @param string $newPriority Новое значение приоритета
     * @return void
     **/
    public function HeapIncreasePriority(int $index, string $newPriority)
    {
        # code...
    }

    /**
     * Изменение значения элемента
     *
     * @param int $index Индекс элемента, приоритет которого нужно уменьшить в min-heap
     * @param string $newPriority Новое значение приоритета
     * @return void
     **/
    public function HeapDecreasePriority(int $index, string $newPriority)
    {
        # code...
    }

    /**
     * Добавление произвольного элемента в конец кучи, 
     * и восстановление свойства упорядоченности с помощью Heap_Increase_Key
     *
     * @param string $priority Значение приоритета, добавляемого элемента
     * @return void
     **/
    public function heapInsert(string $priority)
    {
        # code...
    }

    /**
     * Возвращает значение корневого элемента
     * 
     * 1) значение корневого элемента сохраняется для последующего возврата,
     * 2) последний элемент копируется в корень, после чего удаляется из кучи,
     * 3) вызывается Heapify для корня, 
     * 4) сохранённый элемент возвращается
     *
     * @param void
     * @return string
     **/
    public function HeapExtractTop()
    {
        # code...
    }

}

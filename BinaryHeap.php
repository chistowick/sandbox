<?php

/**
 * Двоичная куча или сортирующее дерево
 * 1) Значение в любой вершине не меньше(не больше для min-heap), значениям её потомков
 * 2) Глубина всех листьев отличается не более чем на 1 слой
 * 3) Последний слой заполняется слева направо без пропусков
 */
class BinaryHeap
{

    /** @var string $mode max|min для режимов max-heap|min-heap соответственно */
    protected $mode;

    /** @var array $A Массив для хранения двоичной кучи */
    public $A;

    /** @var int $heapSize Размер массива с кучей */
    protected $heapSize;

    /**
     * @param string $mode max|min для режимов max-heap|min-heap соответственно
     * @param array $startArray Массив данных для построения кучи (важно: ключи должны начинаться с 1)
     * @return void
     **/
    public function __construct(string $mode = "max", array $startArray = [])
    {
        $this->mode = $mode;
        $this->A = $startArray;
        $this->heapSize = count($startArray);

        // Превращаем массив в двоичную кучу
        $this->buildHeap();
    }

    /**
     * Восстановление свойств кучи
     * 
     * @param int $index Индекс измененного элемента
     * @return void
     **/
    public function heapify(int $index): void
    {
        // Определяем индексы потомков измененного элемента (при условии, что ключ первого элемента дерева - "1")
        $left = $index * 2;
        $right = ($index * 2) + 1;

        // Текущий размер массива с кучей
        $heapSize = $this->heapSize;

        /**
         * Сравниваем значение измененного элемента с потомками
         * и меняем местами с наибольшим/наименьшим(в зависимости от mode), если это необходимо
         */
        if ($this->mode === "max") {

            $largest = $index;

            if ($left <= $heapSize && ($this->A[$left] > $this->A[$largest])) {
                $largest = $left;
            }

            if ($right <= $heapSize && ($this->A[$right] > $this->A[$largest])) {
                $largest = $right;
            }

            // Если свойства кучи нарушены
            if ($largest != $index) {

                // Меняем местами узлы
                $temp = $this->A[$index];
                $this->A[$index] = $this->A[$largest];
                $this->A[$largest] = $temp;

                // и продолжаем применять heapify дальше
                $this->heapify($largest);
            }
        } elseif ($this->mode === "min") {

            $smallest = $index;

            if ($left <= $heapSize && ($this->A[$left] < $this->A[$smallest])) {
                $smallest = $left;
            }

            if ($right <= $heapSize && ($this->A[$right] < $this->A[$smallest])) {
                $smallest = $right;
            }

            // Если свойства кучи нарушены
            if ($smallest != $index) {

                // Меняем местами узлы
                $temp = $this->A[$index];
                $this->A[$index] = $this->A[$smallest];
                $this->A[$smallest] = $temp;

                // и продолжаем применять heapify дальше
                $this->heapify($smallest);
            }
        } else {
            echo "Что-то пошло не так! Mode для Heap не определен";
        }
    }

    /**
     * Построение кучи из неупорядоченного массива входных данных
     *
     * @param void
     * @return void
     **/
    protected function buildHeap(): void
    {

        // Определяем сколько элементов имеют потомков
        $parentsNum = intdiv($this->heapSize, 2);

        // Применяем heapify ко всем узлам имеющим потомков(от последнего к первому)
        for ($i = $parentsNum; $i >= 1; $i--) {
            $this->heapify($i);
        }
    }

    /**
     * Пирамидальная сортировка массива данных без привлечения дополнительной памяти (вспомогательная функция)
     * Modes:
     * min - по убыванию
     * max - по возрастанию
     *
     * @param void
     * @return void
     **/
    public function heapSort()
    {
        // Начальный размер массива с кучей
        $heapSize = $this->heapSize;

        for ($i = $heapSize; $i >= 1; $i--) {
            // Меняем местами первый с последним (формально последним)
            $temp = $this->A[$i];
            $this->A[$i] = $this->A[1];
            $this->A[1] = $temp;

            // Формально уменьшаем размер кучи на "1", чтобы исключить i-ый элемент из расчетов в heapify()
            $this->heapSize--;

            // Восстанавливаем свойства кучи для всех (формально) оставшихся в куче элементов
            $this->heapify(1);
        }

        // Восстанавливаем действительное значение размера массива с кучей
        $this->heapSize = count($this->A);
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

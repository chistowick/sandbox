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
    protected $A;

    /** @var int $heapSize Размер массива с кучей */
    protected $heapSize;

    /**
     * @param string $mode max|min для режимов max-heap|min-heap соответственно
     * @param array $startArray Массив данных для построения кучи (важно: ключи должны начинаться с 1)
     * @return void
     **/
    public function __construct(string $mode = 'max', array $startArray = [])
    {
        if (in_array($mode, ['max', 'min'])) {
            $this->mode = $mode;
        } else {
            $this->mode = 'max';
        }

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
    public function sort()
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
     * Изменение значения приоритета элемента
     *
     * @param int $index Индекс элемента, приоритет которого нужно изменить
     * @param string $newPriority Новое значение приоритета
     * @return void
     **/
    public function changePriority(int $index, string $newPriority)
    {
        if ($index > $this->heapSize) {
            echo "Элемента с таким индексом не существует";
            return;
        }
        $lastPriority = $this->A[$index];

        // Меняем приоритет элемента с заданным индексом на новый
        $this->A[$index] = $newPriority;

        // В режиме max-heap
        if ($this->mode === 'max') {

            // Если новый приоритет меньше, чем прежний
            if ($newPriority < $lastPriority) {

                // Просто вызываем heapify для измененного элемента и сортируем его в низ кучи
                $this->heapify($index);
            } else {

                /**
                 * Иначе пока не достигнута вершина, и пока родитель меньше текущего элемента,
                 * продолжаем "всплытие" измененного элемента
                 */
                while (($index > 1) && ($this->A[intdiv($index, 2)] < $this->A[$index])) {

                    // Меняем родителя и текущий элемент местами
                    $temp = $this->A[$index];
                    $this->A[$index] = $this->A[intdiv($index, 2)];
                    $this->A[intdiv($index, 2)] = $temp;

                    // Новый индекс элемента
                    $index = intdiv($index, 2);
                }
            }
        } elseif ($this->mode === 'min') {
            // В режиме min-heap

            // Если новый приоритет больше, чем прежний
            if ($newPriority > $lastPriority) {

                // Просто вызываем heapify для измененного элемента и сортируем его в низ кучи
                $this->heapify($index);
            } else {

                /**
                 * Иначе пока не достигнута вершина, и пока родитель больше текущего элемента,
                 * продолжаем "всплытие" измененного элемента
                 */
                while (($index > 1) && ($this->A[intdiv($index, 2)] > $this->A[$index])) {

                    // Меняем родителя и текущий элемент местами
                    $temp = $this->A[$index];
                    $this->A[$index] = $this->A[intdiv($index, 2)];
                    $this->A[intdiv($index, 2)] = $temp;

                    // Новый индекс элемента
                    $index = intdiv($index, 2);
                }
            }
        }
    }

    /**
     * Добавление произвольного элемента в конец кучи, 
     * и восстановление свойства упорядоченности с помощью changePriority()
     *
     * @param string $priority Значение приоритета, добавляемого элемента
     * @return void
     **/
    public function insert(string $priority)
    {
        // Увеличиваем величину массива кучи на "1"
        $this->heapSize++;

        // Добавляем новый элемент в конец кучи с заведомо завышенным/заниженным приоритетом
        if ($this->mode === 'max') {
            $this->A[$this->heapSize] = -INF;
        } elseif ($this->mode === 'min') {
            $this->A[$this->heapSize] = INF;
        }

        // Меняем значение на необходимое
        $this->changePriority($this->heapSize, $priority);
    }

    /**
     * Возвращает значение корневого элемента и удаляет его из кучи, затем восстанавливает свойства кучи
     *
     * @param void
     * @return string
     **/
    public function extractTop()
    {
        if ($this->heapSize == 0) {
            echo "Куча пуста!";
            return;
        }

        // Запоминаем верхний элемент
        $top = $this->A[1];

        if ($this->heapSize > 1) {

            // Копируем последний элемент в корень дерева (top) и удаляем его (последний элемент) из массива кучи
            $this->A[1] = array_pop($this->A);
        } else {
            // Иначе просто удаляем последний элемент из кучи
            array_pop($this->A);
        }

        // Устанавливаем действительное значение размера массива с кучей
        $this->heapSize = count($this->A);

        // Вызываем Heapify для корня
        $this->heapify(1);

        return $top;
    }

    /**
     * Распечатывает массив с кучей
     *
     * @param void
     * @return void
     **/
    public function printHeap()
    {
        return print_r($this->A);
    }
}

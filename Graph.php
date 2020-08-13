<?php

/**
 * Граф (взвешенный, неориентированный)
 * 
 * Для реализации итеративного DFS необходимо подключение классов Node, Stack и LinkedList
 */
class Graph
{
    /** 
     * @var array $adjacencyMatrix Матрица смежности. 
     * Ребра графа вида $adjacencyMatrix['A']['B'] = edgeValue 
     * */
    protected $adjacencyMatrix;

    /** @var array $discovered Массив известных вершин */
    protected $discovered = [];

    public function __construct()
    {
        $this->adjacencyMatrix = [];
    }

    /**
     * Добавить вершину
     *
     * @param string $vertexName Имя вершины
     * @return void
     **/
    public function addVertex(string $vertexName)
    {
        $this->adjacencyMatrix[$vertexName] = [];
    }

    /**
     * Установить значение веса ребра между вершинами №1 и №2
     *
     * @param string $vertex_1 Вершина №1
     * @param string $vertex_2 Вершина №2
     * @param string $weight Вес ребра между вершинамаи №1 и №2
     * @return void
     **/
    public function addEdge(string $vertex_1, string $vertex_2, string $weight)
    {
        $this->adjacencyMatrix[$vertex_1][$vertex_2] = $weight;
        $this->adjacencyMatrix[$vertex_2][$vertex_1] = $weight;
    }

    /**
     * Возвращает имена всех вершин из матрицы смежности
     *
     * @param void
     * @return iterable (string) Имена вершин, как ключи из матрицы смежности
     **/
    public function getListVertices(): iterable
    {
        foreach ($this->adjacencyMatrix as $vertex_from => $edge) {
            yield $vertex_from;
        }
    }

    /**
     * Возвращает все смежные вершины и веса ребер к ним для заданного истока - $vertex_from
     *
     * @param string $vertex_from Вершина - исток, относительно которой ведется поиск
     * @return iterable (array: $vertex_to => $weight) "вершина назначения" => "вес ребра"
     **/
    public function getAdjacentEdges(string $vertex_from): iterable
    {
        foreach ($this->adjacencyMatrix[$vertex_from] as $vertex_to => $weight) {
            yield $vertex_to => $weight;
        }
    }

    /**
     * Рекурсивный поиск "сначала в глубину" (Depth-first search)
     * Заполняет массив известных вершин $discovered
     *
     * @param string $vertexName Имя стартовой вершины
     * @return void
     **/
    public function recursiveDfs(string $vertexName): void
    {
        /**
         * При первом запуске функции счетчик уровней рекурсии устанавливается равным "0"
         * Далее номер слоя рекурсии увеличивается в начале функции и уменьшается в конце
         **/
        static $counter = 0;

        // Если это самый верхний вызов в рекурсии
        if ($counter == 0) {

            // Предварительно опустошаем массив известных вершин
            $this->discovered = [];
        }

        $counter++;

        // Запоминаем посещаемую вершину
        $this->discovered[$vertexName] = true;

        // Итерируем смежные вершины 
        foreach ($this->getAdjacentEdges($vertexName) as $vertex_to => $weight) {
            // Если вершина ещё не известна
            if (!isset($this->discovered[$vertex_to])) {
                // Рекурсивно вызываем DFS относительно новой вершины
                $this->recursiveDfs($vertex_to);
            }
        }

        $counter--;
    }

    /**
     * Итеративный поиск "сначала в глубину" (Depth-first search)
     * Заполняет массив известных вершин $discovered
     *
     * @param string $vertexName Имя стартовой вершины
     * @return void
     **/
    public function iterativeDfs(string $vertexName): void
    {
        // Предварительно опустошаем массив известных вершин
        $this->discovered = [];

        $S = new Stack();

        // Кладем стартовую вершину в стек
        $S->push($vertexName);

        // Пока стек не пуст
        while (!$S->isEmpty()) {

            // Извлекаем вершину из головы стека
            $currentVertex = $S->pop();

            // Если текущая вершина ещё не известна
            if (!isset($this->discovered[$currentVertex])) {

                // Запоминаем текущую вершину
                $this->discovered[$currentVertex] = true;

                // Итерируем смежные вершины 
                foreach ($this->getAdjacentEdges($currentVertex) as $vertex_to => $weight) {
                    // Каждую помещаем в стек
                    $S->push($vertex_to);
                }
            }
        }
    }

    /**
     * Возвращает массив известных вершин $discovered
     *
     * @param void
     * @return array $discovered Массив известных вершин
     **/
    public function getDiscovered(): array
    {
        return $this->discovered;
    }
}

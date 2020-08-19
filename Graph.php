<?php

/**
 * Граф (взвешенный, неориентированный)
 * 
 * Для реализации итеративного DFS необходимо подключение классов Node, Stack и LinkedList
 * Для реализации итеративного DFS необходимо подключение классов Node, Queue и LinkedList
 * Для реализации алгоритма Дейкстры необходим класс BinaryHeap
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
     * Итеративный поиск "сначала в шириину" (Breadth-first search)
     * Заполняет массив известных вершин $discovered
     *
     * @param string $vertexName Имя стартовой вершины
     * @return void
     **/
    public function iterativeBfs(string $vertexName): void
    {
        // Предварительно опустошаем массив известных вершин
        $this->discovered = [];

        $Q = new Queue();

        // Запоминаем стартовую вершину
        $this->discovered[$vertexName] = true;

        // Помещаем стартовую вершину в очередь
        $Q->enqueue($vertexName);

        // Пока очередь не пуста
        while (!$Q->isEmpty()) {

            // Извлекаем вершину из головы очереди
            $currentVertex = $Q->dequeue();

            // Итерируем смежные вершины 
            foreach ($this->getAdjacentEdges($currentVertex) as $vertex_to => $weight) {

                // Если смежная вершина ещё не известна
                if (!isset($this->discovered[$vertex_to])) {

                    // Запоминаем её
                    $this->discovered[$vertex_to] = true;

                    // И помещаем в конец очереди
                    $Q->enqueue($vertex_to);
                }
            }
        }
    }

    /**
     * Алгоритм Дейкстры
     * 
     * @param string $source Исток
     * @return array Массив дистанций и предшественников
     **/
    public function Dijkstra(string $source)
    {
        // Проверяем наличие вершины-источника в графе
        if (!array_key_exists($source, $this->adjacencyMatrix)) {
            echo "Вершина не найдена";
            return;
        }
        // Расстояние от source до определенной вершины
        $distance = [];
        // Указатель на предыдущую вершину в найденном маршруте
        $previous = [];

        // Массив с информацией о посещенных вершинах
        $visited = [];

        // Считаем путь от истока до самого себя равным нулю
        $distance[$source] = 0;

        // Создаем очередь с приоритетом на основе двоичной кучи в режиме min-heap
        $prQ = new BinaryHeap('min');

        // Изначально, для всех вершин графа
        foreach ($this->adjacencyMatrix as $vertex_from => $value) {
            // кроме источника
            if ($vertex_from != $source) {

                // считаем дистанцию от истока до этих вершин ($vertex_from) бесконечной
                $distance[$vertex_from] = INF;

                // а предыдущую вершину для $vertex_from в кротчайшем пути от истока - неопределенной
                $previous[$vertex_from] = null;
            }

            /**
             * все вершины вместе с истоком добавляем в очередь с приоритетами равными принятой дистанции до них
             * (куча при добавлении элементов автоматически их встраивает в кучу)
             */
            $prQ->insert($vertex_from, $distance[$vertex_from]);

            // Считаем все вершины непосещенными
            $visited[$vertex_from] = false;
        }

        // Пока куча не пустая
        while (!$prQ->isEmpty()) {

            /**
             * Извлекаем и удаляем из кучи Node вершину с наименьшим приоритетом 
             * (наименьшим расстоянием от истока до неё)
             */
            $currentNode = $prQ->extractTop();

            // Получаем имя текущей вершины
            $currentVertex = $currentNode->getNodeValue();

            // Запоминаем вершину как посещенную
            $visited[$currentVertex] = true;

            // Для всех соседей текущей вершины
            foreach ($this->getAdjacentEdges($currentVertex) as $vertex_to => $weight) {

                // которые ещё присутствуют в куче (то есть не посещены)
                if (!$visited[$vertex_to]) {

                    /**
                     * Складываем значение дистанции от истока до текущей вершины с дистанцией (весом) 
                     * до соседней вершины - таким образом находим возможное расстояние до $vertex_to
                     */
                    $alt = $distance[$currentVertex] + $weight;

                    // если найденное расстояние короче уже известного наикратчайшего пути
                    if ($alt < $distance[$vertex_to]) {

                        // Перезаписваем кратчайший путь новым значением
                        $distance[$vertex_to] = $alt;

                        /**
                         * Ставим метку о том, что последний наикратчайший путь к вершине $vertex_to 
                         * был проложен из вершины $currentVertex
                         */
                        $previous[$vertex_to] = $currentVertex;

                        // В куче находим ключ node, соответствующего вершине $vertex_to
                        $index = $prQ->firstKey($vertex_to);

                        /**
                         * Соответственно понижаем приоритет узла с вершиной $vertex_to до нового значения,
                         * равного наименьшей известной дистанции (весу) до $vertex_to
                         */
                        $prQ->changePriority($index, $alt);
                    }
                }
            }
        }

        return array($distance, $previous);
    }

    /**
     * Поиск характеристик кратчайшего маршрута между вершинами
     *
     * @param string $from Исток
     * @param string $to Сток
     * @return array (Вес, Путь)
     **/
    public function shortestRoute(string $from, string $to)
    {
        if(!isset($from, $to)){

            echo "Ошибка в указании начала или конца пути";
            return;
        }

        list($distance, $previous) = $this->Dijkstra($from);

        // Вес маршрута из массива наименьших весов
        $weight = $distance[$to];

        $steps[] = $to;

        while ($previous[$to] != $from) {

            $steps[] = $previous[$to];
            $to = $previous[$to];
        }

        $steps[] = $from;

        $path = "";

        while ($steps) {
            $path .= array_pop($steps);
            $path .= ">";
        }

        $path = trim($path, ">");

        return array($weight, $path);
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

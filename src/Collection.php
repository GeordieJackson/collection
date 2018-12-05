<?php
    
    namespace GeordieJackson\Collection;

    use Countable;
    use ArrayAccess;
    use ArrayIterator;
    use IteratorAggregate;

    /**
     * Class Collection
     *
     * @package GeordieJackson\Collection\Classes
     */
    class Collection implements ArrayAccess, Countable, IteratorAggregate
    {
        /**
         * @var
         */
        protected $items;
    
        /**
         *  --------------  Collection's constructors  -----------------
         */
    
        /**
         * Collection constructor.
         *
         * @param $items
         */
        public function __construct($items)
        {
            $this->items = $items;
        }
    
        /**
         * @param $items
         * @return \GeordieJackson\Collection\Collection
         */
        public static function make($items) : Collection
        {
            return new static($items);
        }
        
    
        /**
         *  --------------  Collection's functions  -----------------
         */
    
        /**
         * @return array
         */
        public function toArray() : array
        {
            return $this->items;
        }
    
        /**
         * @return array
         */
        public function all() : array
        {
            return $this->toArray();
        }
    
        /**
         * @param callable $callback
         * @return $this
         */
        public function each(callable $callback) : Collection
        {
            foreach ($this->items as $key => $item) {
                if ($callback($item, $key) === false) {
                    break;
                }
            }
        
            return $this;
        }
    
        /**
         * @param $callback
         * @return \GeordieJackson\Collection\Collection
         */
        public function map(callable $callback) : Collection
        {
            return static::make(array_map($callback, $this->items));
        }
        
        /**
         * @param $callback
         * @return \GeordieJackson\Collection\Classes\Collection
         */
        public function filter(callable $callback) : Collection
        {
            return static::make(array_filter($this->items, $callback));
        }
    
        /**
         * @param callable $callback
         * @return $this
         */
        public function transform(callable $callback) : Collection
        {
            $this->items = $this->map($callback)->all();
        
            return $this;
        }
    
        /**
         * @return \GeordieJackson\Collection\Collection
         */
        public function keys() : Collection
        {
            return static::make(array_keys($this->items));
        }
    
        /**
         * @return \GeordieJackson\Collection\Collection
         */
        public function values() : Collection
        {
            return static::make(array_values($this->items));
        }
    
    
        /**
         *  --------------  Set up the array-like behaviours  -----------------
         */
    
        /**
         * @return int
         */
        public function count()
        {
            return count($this->items);
        }
    
        /**
         * @param $offset
         * @return bool
         */
        public function offsetExists($offset)
        {
            return array_key_exists($offset, $this->items);
        }
        
        /**
         * @param $offset
         * @return mixed
         */
        public function offsetGet($offset)
        {
            return $this->items[$offset];
        }
        
        /**
         * @param $offset
         * @param $value
         */
        public function offsetSet($offset, $value)
        {
            if($offset === null) {
                $this->items[] = $value;
            } else {
                $this->items[$offset] = $value;
            }
        }
        
        /**
         * @param $offset
         */
        public function offsetUnset($offset)
        {
            unset($this->items[$offset]);
        }
    
        /**
         * @return \ArrayIterator
         */
        public function getIterator()
        {
            return new ArrayIterator($this->items);
        }
    }
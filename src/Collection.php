<?php
    
    namespace GeordieJackson\Collection;
    
    use ArrayAccess;
    use ArrayIterator;
    use Countable;
    use IteratorAggregate;
    use stdClass;
    
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
        public function __construct($items = [])
        {
            $this->items = $items;
        }
        
        /**
         * @param $items
         * @return \GeordieJackson\Collection\Collection
         */
        public static function make($items = []) : Collection
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
         * @param      $key
         * @param null $operator
         * @param null $value
         * @return bool
         */
        public function contains($key, $operator = null, $value = null)
        {
            if(func_num_args() === 1) {
                if($this->useAsCallable($key)) {
                    $placeholder = new stdClass;
                    
                    return $this->first($key, $placeholder) !== $placeholder;
                }
                
                return in_array($key, $this->items);
            }
            
            return $this->contains($this->operatorForWhere(...func_get_args()));
        }
    
        /**
         * @param      $key
         * @param null $value
         * @return bool
         */
        public function containsStrict($key, $value = null)
        {
            if (func_num_args() === 2) {
                return $this->contains(function ($item) use ($key, $value) {
                    return data_get($item, $key) === $value;
                });
            }
        
            if ($this->useAsCallable($key)) {
                return ! is_null($this->first($key));
            }
        
            return in_array($key, $this->items, true);
        }
        
        /**
         * @param callable $callback
         * @return $this
         */
        public function each(callable $callback) : Collection
        {
            foreach($this->items as $key => $item) {
                if($callback($item, $key) === false) {
                    break;
                }
            }
            
            return $this;
        }
        
        /**
         * @param callable|null $callback
         * @param null          $default
         * @return mixed
         */
        public function first(callable $callback = null, $default = null)
        {
            return Arr::first($this->items, $callback, $default);
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
         * @return \GeordieJackson\Collection\Collection
         */
        public function keys() : Collection
        {
            return static::make(array_keys($this->items));
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
        
        /**
         * @param      $key
         * @param null $operator
         * @param null $value
         * @return \Closure
         */
        protected function operatorForWhere($key, $operator = null, $value = null)
        {
            if(func_num_args() === 1) {
                $value = true;
                
                $operator = '=';
            }
            
            if(func_num_args() === 2) {
                $value = $operator;
                
                $operator = '=';
            }
            
            return function($item) use ($key, $operator, $value) {
                $retrieved = data_get($item, $key);
                
                $strings = array_filter([$retrieved, $value], function($value) {
                    return is_string($value) || (is_object($value) && method_exists($value, '__toString'));
                });
                
                if(count($strings) < 2 && count(array_filter([$retrieved, $value], 'is_object')) == 1) {
                    return in_array($operator, ['!=', '<>', '!==']);
                }
                
                switch($operator) {
                    default:
                    case '=':
                    case '==':
                        return $retrieved == $value;
                    case '!=':
                    case '<>':
                        return $retrieved != $value;
                    case '<':
                        return $retrieved < $value;
                    case '>':
                        return $retrieved > $value;
                    case '<=':
                        return $retrieved <= $value;
                    case '>=':
                        return $retrieved >= $value;
                    case '===':
                        return $retrieved === $value;
                    case '!==':
                        return $retrieved !== $value;
                }
            };
        }
        
        /**
         * @param $value
         * @return bool
         */
        protected function useAsCallable($value)
        {
            return ! is_string($value) && is_callable($value);
        }
    }
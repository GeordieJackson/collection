<?php
    
    namespace GeordieJackson\Collection;
    
    use ArrayAccess;
    use phpDocumentor\Reflection\Types\Boolean;

    class Arr
    {
        /**
         * @param $value
         * @return bool
         */
        public static function accessible($value) : bool
        {
            return is_array($value) || $value instanceof ArrayAccess;
        }
    
        /**
         * Add an element to an array using "dot" notation if it doesn't exist.
         *
         * @param  array   $array
         * @param  string  $key
         * @param  mixed   $value
         * @return array
         */
        public static function add($array, $key, $value) : array
        {
            if (is_null(static::get($array, $key))) {
                static::set($array, $key, $value);
            }
        
            return $array;
        }
    
        /**
         * Divide an array into two arrays. One with keys and the other with values.
         *
         * @param  array  $array
         * @return array
         */
        public static function divide($array) : array
        {
            return [array_keys($array), array_values($array)];
        }
    
        /**
         * Flatten a multi-dimensional associative array with dots.
         *
         * @param  array   $array
         * @param  string  $prepend
         * @return array
         */
        public static function dot($array, $prepend = '') : array
        {
            $results = [];
        
            foreach ($array as $key => $value) {
                if (is_array($value) && ! empty($value)) {
                    $results = array_merge($results, static::dot($value, $prepend.$key.'.'));
                } else {
                    $results[$prepend.$key] = $value;
                }
            }
        
            return $results;
        }
        
        /**
         * @param $value
         * @return array
         */
        public static function wrap($value) : array
        {
            if(is_null($value)) {
                return [];
            }
            
            return is_array($value) ? $value : [$value];
        }
    
        /**
         * @param $array
         * @return array
         */
        public static function collapse($array) : array
        {
            $results = [];
            
            foreach($array as $values) {
                if($values instanceof Collection) {
                    $values = $values->all();
                } elseif( ! is_array($values)) {
                    continue;
                }
                
                $results = array_merge($results, $values);
            }
            
            return $results;
        }
    
        /**
         * @param $array
         * @param $depth
         * @return array
         */
        public static function flatten($array, $depth = INF) : array
        {
            $result = [];
        
            foreach ($array as $item) {
                $item = $item instanceof Collection ? $item->all() : $item;
            
                if (! is_array($item)) {
                    $result[] = $item;
                } elseif ($depth === 1) {
                    $result = array_merge($result, array_values($item));
                } else {
                    $result = array_merge($result, static::flatten($item, $depth - 1));
                }
            }
        
            return $result;
        }
    
        /**
         * Get an item from an array using "dot" notation.
         *
         * @param  \ArrayAccess|array  $array
         * @param  string  $key
         * @param  mixed   $default
         * @return mixed
         */
        public static function get($array, $key, $default = null)
        {
            if (! static::accessible($array)) {
                return value($default);
            }
        
            if (is_null($key)) {
                return $array;
            }
        
            if (static::exists($array, $key)) {
                return $array[$key];
            }
        
            if (strpos($key, '.') === false) {
                return $array[$key] ?? value($default);
            }
        
            foreach (explode('.', $key) as $segment) {
                if (static::accessible($array) && static::exists($array, $segment)) {
                    $array = $array[$segment];
                } else {
                    return value($default);
                }
            }
        
            return $array;
        }
    
        /**
         * Determine if the given key exists in the provided array.
         *
         * @param  \ArrayAccess|array  $array
         * @param  string|int  $key
         * @return bool
         */
        public static function exists($array, $key) : bool
        {
            if ($array instanceof ArrayAccess) {
                return $array->offsetExists($key);
            }
        
            return array_key_exists($key, $array);
        }
    
        /**
         * @param               $array
         * @param callable|null $callback
         * @param null          $default
         * @return mixed
         */
        public static function first($array, callable $callback = null, $default = null)
        {
            if (is_null($callback)) {
                if (empty($array)) {
                    return value($default);
                }
            
                foreach ($array as $item) {
                    return $item;
                }
            }
        
            foreach ($array as $key => $value) {
                if (call_user_func($callback, $value, $key)) {
                    return $value;
                }
            }
        
            return value($default);
        }
    
        /**
         * Set an array item to a given value using "dot" notation.
         *
         * If no key is given to the method, the entire array will be replaced.
         *
         * @param  array   $array
         * @param  string  $key
         * @param  mixed   $value
         * @return array
         */
        public static function set(&$array, $key, $value) : array
        {
            if (is_null($key)) {
                return $array = $value;
            }
        
            $keys = explode('.', $key);
        
            while (count($keys) > 1) {
                $key = array_shift($keys);
                
                if (! isset($array[$key]) || ! is_array($array[$key])) {
                    $array[$key] = [];
                }
            
                $array = &$array[$key];
            }
        
            $array[array_shift($keys)] = $value;
        
            return $array;
        }
    }
<?php
    
    namespace GeordieJackson\Collection;
    
    use ArrayAccess;
    
    class Arr
    {
        /**
         * @param $value
         * @return bool
         */
        public static function accessible($value)
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
        public static function add($array, $key, $value)
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
        public static function divide($array)
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
        public static function dot($array, $prepend = '')
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
        public static function collapse($array)
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
        public static function flatten($array, $depth = INF)
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
        public static function exists($array, $key)
        {
            if ($array instanceof ArrayAccess) {
                return $array->offsetExists($key);
            }
        
            return array_key_exists($key, $array);
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
        public static function set(&$array, $key, $value)
        {
            if (is_null($key)) {
                return $array = $value;
            }
        
            $keys = explode('.', $key);
        
            while (count($keys) > 1) {
                $key = array_shift($keys);
            
                // If the key doesn't exist at this depth, we will just create an empty array
                // to hold the next value, allowing us to create the arrays to hold final
                // values at the correct depth. Then we'll keep digging into the array.
                if (! isset($array[$key]) || ! is_array($array[$key])) {
                    $array[$key] = [];
                }
            
                $array = &$array[$key];
            }
        
            $array[array_shift($keys)] = $value;
        
            return $array;
        }
    }
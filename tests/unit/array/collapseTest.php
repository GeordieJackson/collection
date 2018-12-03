<?php
    
    use GeordieJackson\Collection\Arr;
    use GeordieJackson\Collection\Collection;
    
    /**
     * Class collapseTest
     */
    class collapseTest extends \Codeception\Test\Unit
    {
        protected $array;
        protected $tester;
        protected $expected;
        protected $collection;
        
        protected function _before()
        {
            $this->array = [
                [1, 2, 3],
                [4, 5, 6],
                ['a', 'b', 'c'],
            ];
    
            $this->collection = Collection::make($this->array);
            $this->expected = [1, 2, 3, 4, 5, 6, 'a', 'b', 'c'];
        }
        
        /**
         * @test
         */
        public function it_collapses_array_of_arrays_into_a_single_array()
        {
            $this->assertEquals($this->expected, Arr::collapse($this->array));
            
            $this->assertTrue(is_array(Arr::collapse($this->collection)));
            $this->assertEquals($this->expected, Arr::collapse($this->collection));
        }
        
        protected function _after()
        {
        }
    }
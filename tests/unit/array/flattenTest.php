<?php
    
    use GeordieJackson\Collection\Arr;
    use GeordieJackson\Collection\Collection;
    
    class flattenTest extends \Codeception\Test\Unit
    {
        /**
         * @var \UnitTester
         */
        protected $tester;
        protected $multi;
        protected $expected_INF;
        protected $expected_1_level;
        protected $collection;
        
        protected function _before()
        {
            $this->multi = [
                [
                    ['value1', 'value2'],
                    ['value3', 'value4'],
                ],
                [
                    ['value5', 'value6'],
                    ['value7', 'value8'],
                ],
            ];
            
            $this->collection = Collection::make($this->multi);
            
            $this->expected_1_level = [
                ['value1', 'value2'],
                ['value3', 'value4'],
                ['value5', 'value6'],
                ['value7', 'value8'],
            ];
            
            $this->expected_INF = [
                'value1',
                'value2',
                'value3',
                'value4',
                'value5',
                'value6',
                'value7',
                'value8',
            ];
        }
        
        /**
        * @test
        */
        public function it_flattens_arrays_to_chosen_depth()
        {
            $this->assertEquals($this->expected_1_level, Arr::flatten($this->multi, 1));
            $this->assertEquals($this->expected_1_level, Arr::flatten($this->collection, 1));
            $this->assertEquals($this->expected_INF, Arr::flatten($this->multi));
            $this->assertEquals($this->expected_INF, Arr::flatten($this->collection));
        }
        
        protected function _after()
        {
        }
    }
<?php
    
    use GeordieJackson\Collection\Arr;
    use GeordieJackson\Collection\Collection;
    
    class getTest extends \Codeception\Test\Unit
    {
        /**
         * @var \UnitTester
         */
        protected $tester;
        protected $array;
        protected $array_1;
        protected $collection;
        
        protected function _before()
        {
            $this->array = [
                ['name' => 'Mary', 'email' => 'mary@example.com', 'salaried' => true],
                ['name' => 'John', 'email' => 'john@example.com', 'salaried' => false],
                ['name' => 'Kelly', 'email' => 'kelly@example.com', 'salaried' => true],
                ['name' => 'Billy', 'email' => 'billy@fustees.com', 'salaried' => true],
                ['name' => 'Wendy', 'email' => null, 'salaried' => true],
                ['name' => 'Arthur', 'email' => 'arthur@bisquits.com', 'salaried' => false],
            ];
            
            $this->array_1 = $this->array[1];
            
            $this->collection = Collection::make($this->array);
        }
        
        /**
        * @test
        */
        public function it_returns_value_using_an_index()
        {
            $this->assertEquals($this->array_1, Arr::get($this->array, 1));
            
            $this->assertEquals($this->array_1, Arr::get($this->collection,
                1));
        }
        
        /**
        * @test
        */
        public function it_returns_value_using_index_and_name()
        {
            $this->assertEquals($this->array_1['name'], Arr::get($this->array, '1.name'));
    
            $this->assertEquals($this->array_1['name'], Arr::get($this->collection,
                '1.name'));
        }
        
        protected function _after()
        {
        }
    }
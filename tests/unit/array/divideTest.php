<?php
    
    use GeordieJackson\Collection\Arr;
    
    class divideTest extends \Codeception\Test\Unit
    {
        /**
         * @var \UnitTester
         */
        protected $tester;
        protected $array;
        protected $keys;
        protected $values;
        
        protected function _before()
        {
            $this->array = ['name' => 'Billy', 'email' => 'billy@fustees.com', 'salaried' => true];
            
            $this->keys = ['name', 'email', 'salaried'];
            $this->values = ['Billy', 'billy@fustees.com', true];
        }
        
        /**
        * @test
        */
        public function it_divides_an_array_into_keys_and_values()
        {
            $divided = Arr::divide($this->array);
            $this->assertEquals($this->keys, $divided[0]);
            $this->assertEquals($this->values, $divided[1]);
        }
        
        protected function _after()
        {
        }
    }
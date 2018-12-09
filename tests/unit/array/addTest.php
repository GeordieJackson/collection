<?php
    
    namespace GeordieJackson\Collection\Tests\Arr;
    
    use GeordieJackson\Collection\Arr;
    
    class addTest extends \Codeception\Test\Unit
    {
        /**
         * @var \UnitTester
         */
        protected $tester;
        protected $array;
        
        protected function _before()
        {
            $this->array = ['name' => 'Mary', 'email' => 'mary@example.com', 'salaried' => true];
        }
        
        /**
         * @test
         */
        public function it_adds_a_value_to_array()
        {
            $arr = Arr::add($this->array, 'added', 'value');
            $this->assertArrayHasKey('added', $arr);
            
            $arr = Arr::add($arr, 'cars.volvo', 'S90');
            $this->assertArrayHasKey('volvo', $arr['cars']);
            $this->assertEquals('S90', $arr['cars']['volvo']);
        }
        
        /**
        * @test
        */
        public function it_does_not_add_if_key_exists()
        {
            $arr = Arr::add($this->array, 'name', 'Arthur');
            $this->assertEquals('Mary', $arr['name']);
        }
        
        protected function _after()
        {
        }
    }
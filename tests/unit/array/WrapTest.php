<?php
    
    namespace GeordieJackson\Collection\Tests\Arr;
    
    use GeordieJackson\Collection\Arr;
    
    class WrapTest extends \Codeception\Test\Unit
    {
        /**
         * @var \UnitTester
         */
        protected $tester;
        
        protected function _before()
        {
        }
        
        /**
        * @test
        */
        public function it_WRAPS_vars_in_an_array()
        {
            $wrapped = Arr::wrap("");
            $this->assertTrue(is_array($wrapped));
    
            $wrapped = Arr::wrap("string");
            $this->assertTrue(is_array($wrapped));
    
            $wrapped = Arr::wrap(null);
            $this->assertTrue(is_array($wrapped));
    
            $wrapped = Arr::wrap(0);
            $this->assertTrue(is_array($wrapped));
    
            $wrapped = Arr::wrap([1,2,3,4,5]);
            $this->assertTrue(is_array($wrapped));
        }
        
        protected function _after()
        {
        }
    }
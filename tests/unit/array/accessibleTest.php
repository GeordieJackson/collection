<?php
    
    namespace GeordieJackson\Collection\Tests\Arr;
    
    use stdClass;
    use GeordieJackson\Collection\Arr;
    use GeordieJackson\Collection\Collection;
    
    class accessibleTest extends \Codeception\Test\Unit
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
        public function is_value_array_accessible()
        {
            $this->assertTrue(Arr::accessible([1,2,3]));
            $this->assertTrue(is_bool(Arr::accessible([1,2,3])));
            $this->assertTrue(Arr::accessible([]));
            $this->assertTrue(Arr::accessible(new Collection([])));
            
            $this->assertFalse(Arr::accessible('string'));
            $this->assertFalse(Arr::accessible(12));
            $this->assertFalse(Arr::accessible(null));
            $this->assertFalse(Arr::accessible(new stdClass()));
        }
        
        protected function _after()
        {
        }
    }
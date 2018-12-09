<?php
    
    namespace GeordieJackson\Collection\Tests\Arr;
    
    use GeordieJackson\Collection\Arr;
    
    class firstTest extends \Codeception\Test\Unit
    {
        protected $array;
        protected $tester;
        
        protected function _before()
        {
            $this->array = $array = [100, 200, 300, 400, 500];
        }
        
        /**
        * @test
        */
        public function it_returns_the_first_item_by_default()
        {
            $this->assertEquals(100, Arr::first($this->array));
        }
        
        /**
        * @test
        */
        public function it_returns_the_first_matching_value()
        {
            $this->assertEquals(300, Arr::first($this->array, function($value, $key) {
                return $value > 250;
            }));
        }
        
        /**
        * @test
        */
        public function it_returns_the_set_default_value_if_no_match_found()
        {
            $this->assertEquals('empty', Arr::first([], null, 'empty'));
    
            $this->assertEquals('empty', Arr::first($this->array, function($value, $key) {
                return $value == 'matched';
            }, 'empty'));
        }
        
        protected function _after()
        {
        }
    }
<?php
    
    namespace GeordieJackson\Collection\Tests\Collection;
    
    class firstTest extends \Codeception\Test\Unit
    {
        /**
         * @var \UnitTester
         */
        protected $tester;
        protected $collection;
        
        protected function _before()
        {
            $this->collection = collect([100, 200, 300, 400, 500]);
        }
    
        /**
         * @test
         */
        public function it_returns_the_first_item_by_default()
        {
            $this->assertEquals(100, $this->collection->first());
        }
    
        /**
         * @test
         */
        public function it_returns_the_first_matching_value()
        {
            $this->assertEquals(300, $this->collection->first(function($value, $key) {
                return $value > 250;
            }));
        }
    
        /**
         * @test
         */
        public function it_returns_the_set_default_value_if_no_match_found()
        {
            $this->assertEquals('empty', collect([])->first( null, 'empty'));
        
            $this->assertEquals('empty', $this->collection->first(function($value, $key) {
                return $value == 'matched';
            }, 'empty'));
        }
        
        protected function _after()
        {
        }
    }
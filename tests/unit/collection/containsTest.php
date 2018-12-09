<?php
    
    namespace GeordieJackson\Collection\Tests\Collection;
    
    class containsTest extends \Codeception\Test\Unit
    {
        /**
         * @var \UnitTester
         */
        protected $tester;
        protected $collection;
        
        protected function _before()
        {
        
        }
        
        /**
        * @test
        */
        public function it_returns_true_when_item_is_present()
        {
            $collection = collect(['name' => 'Desk', 'price' => 100]);
            $this->assertTrue($collection->contains('Desk'));
        }
    
        /**
         * @test
         */
        public function it_returns_false_when_item_is_absent()
        {
            $collection = collect(['name' => 'Desk', 'price' => 100]);
            $this->assertFalse($collection->contains('Chair'));
        }
        
        /**
        * @test
        */
        public function it_can_match_on_key_value_pairs_with_comparison_operator()
        {
            $collection = collect([
                ['product' => 'Desk', 'price' => 200],
                ['product' => 'Chair', 'price' => 100],
            ]);
            
            $this->assertTrue($collection->contains('price', 100));
            $this->assertTrue($collection->contains('price', ">", 150));
            $this->assertFalse($collection->contains('sold', '=', 100));
            $this->assertFalse($collection->contains('price', '<=', 40));
        }
        
        /**
        * @test
        */
        public function it_works_with_a_user_supplied_callback()
        {
            $collection = collect(['name' => 'Desk', 'price' => 100]);
            
            $this->assertTrue($collection->contains(function($value, $key) {
                return $key == 'name';
            }));
    
            $this->assertFalse($collection->contains(function($value, $key) {
                return $key == 'product';
            }));
    
            $this->assertTrue($collection->contains(function($value, $key) {
                return $value == 100;
            }));
    
            $this->assertFalse($collection->contains(function($value, $key) {
                return $value == 200;
            }));
    
            $this->assertTrue($collection->contains(function($value, $key) {
                return $value > 50;
            }));
    
            $this->assertTrue($collection->contains(function($value, $key) {
                return $value == 'Desk';
            }));
    
            // NOTE: This returns true because 'Desk' is interger 0 (!)
            $this->assertTrue($collection->contains(function($value, $key) {
                return $value < 50;
            }));
        }
        
        protected function _after()
        {
        }
    }
<?php
    
    namespace GeordieJackson\Collection\Tests\Collection;
    
    use GeordieJackson\Collection\Collection;
    
    class InitializeCollectionTest extends \Codeception\Test\Unit
    {
        /**
         * @var \UnitTester
         */
        protected $tester;
        protected $array;
    
        protected function _before()
        {
            $this->array = [
                'Billy',
                'Arthur',
                'Crystal',
                'Helmut'
            ];
        }
        
        /**
        * @test
        */
        public function collection_initialises_and_stores_array()
        {
            $collection = new Collection($this->array);
            
            $this->assertInstanceOf(Collection::class, $collection);
            $this->assertContains('Helmut', $collection->toArray());
        }
        
        /**
        * @test
        */
        public function collection_initialises_statically_and_holds_array()
        {
            $collection = Collection::make($this->array);
            
            $this->assertInstanceOf(Collection::class, $collection);
            $this->assertContains('Arthur', $collection->toArray());
        }
        
        /**
        * @test
        */
        public function collect_helper_returns_a_collection_instance()
        {
            $collection = collect($this->array);
    
            $this->assertInstanceOf(Collection::class, $collection);
            $this->assertContains('Billy', $collection->toArray());
        }
        
        /**
        * @test
        */
        public function collection_is_countable()
        {
            $collection = Collection::make($this->array);
    
            $this->assertEquals(4, count($collection));
        }
        
        /**
        * @test
        */
        public function collection_can_be_manipulated_like_an_array()
        {
            $collection = Collection::make($this->array);
            $collection[] = "Wendy";
            unset($collection[0]);
    
            $this->assertTrue(isset($collection[4]));
            $this->assertEquals('Wendy', $collection[4]);
            $this->assertFalse(isset($collection[0]));
        }
        
        /**
        * @test
        */
        public function collection_is_iterable()
        {
            $collection = Collection::make($this->array);
            
            $this->assertTrue(is_iterable($collection));
        }
        
        /**
        * @test
        */
        public function the_collect_helper_method_works()
        {
            $this->assertInstanceOf(Collection::class, collect([]));
        }
        
        protected function _after()
        {
        }
    }
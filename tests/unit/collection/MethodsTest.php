<?php
    
    use GeordieJackson\Collection\Collection;
    
    class MethodsTest extends \Codeception\Test\Unit
    {
        /**
         * @var \UnitTester
         */
        protected $tester;
        protected $collection;
        
        protected function _before()
        {
            $this->collection = Collection::make([
                ['name' => 'mary', 'email' => 'mary@example.com', 'salaried' => true],
                ['name' => 'John', 'email' => 'john@example.com', 'salaried' => false],
                ['name' => 'Kelly', 'email' => 'kelly@example.com', 'salaried' => true],
                ['name' => 'billy', 'email' => 'billy@fustees.com', 'salaried' => true],
                ['name' => 'wendy', 'email' => null, 'salaried' => true],
                ['name' => 'Arthur', 'email' => 'arthur@bisquits.com', 'salaried' => false],
            ]);
        }
        
        /**
         * @test
         */
        public function FILTER_collection_and_return_new_collection_of_filtered_items()
        {
            $salaried = $this->collection->filter(function($item) {
                return $item['salaried'] === true;
            });
            
            $this->assertInstanceOf(Collection::class, $salaried);
            $this->assertEquals(4, $salaried->count());
            $this->assertFalse(isset($salaried[1]));
            $this->assertEquals(['name' => 'Kelly', 'email' => 'kelly@example.com', 'salaried' => true], $salaried[2]);
        }
        
        /**
         * @test
         */
        public function MAP_collection_and_return_a_new_collection_of_mapped_items()
        {
            $mapped = $this->collection->map(function($item) {
                return $item['email'];
            });
            
            $this->assertInstanceOf(Collection::class, $mapped);
            $this->assertEquals($this->collection->count(), $mapped->count());
            $this->assertEquals('kelly@example.com', $mapped[2]);
            $this->assertTrue(is_null($mapped[4]));
        }
        
        /**
         * @test
         */
        public function chain_methods_to_create_a_simple_pipeline()
        {
            $validEmails = $this->collection->filter(function($item) {
                return $item['email'];
            })->map(function($item) {
                return $item['email'];
            })
            ;
            
            $this->assertInstanceOf(Collection::class, $validEmails);
            $this->assertEquals('kelly@example.com', $validEmails[2]);
            $this->assertFalse(isset($validEmails[4]));
        }
        
        /**
         * @test
         */
        public function it_returns_a_collection_of_array_keys()
        {
            $collection = Collection::make([
                'prod-100' => ['product_id' => 'prod-100', 'name' => 'Desk'],
                'prod-200' => ['product_id' => 'prod-200', 'name' => 'Chair'],
            ]);
            
            $this->assertInstanceOf(Collection::class, $collection->keys());
            $this->assertEquals(['prod-100', 'prod-200'], $collection->keys()->toArray());
        }
        
        /**
         * @test
         */
        public function it_returns_a_collection_of_array_values()
        {
            $collection = Collection::make([
                10 => ['product' => 'Desk', 'price' => 200],
                11 => ['product' => 'Desk', 'price' => 200]
            ]);
            
            $this->assertInstanceOf(Collection::class, $collection->values());
            $this->assertEquals([
                0 => ['product' => 'Desk', 'price' => 200],
                1 => ['product' => 'Desk', 'price' => 200],
            ], $collection->values()->toArray());
        }
        
        protected function _after()
        {
        }
    }
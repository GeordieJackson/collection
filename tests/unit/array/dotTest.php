<?php
    
    namespace GeordieJackson\Collection\Tests\Arr;
    
    use GeordieJackson\Collection\Arr;
    
    class dotTest extends \Codeception\Test\Unit
    {
        /**
         * @var \UnitTester
         */
        protected $tester;
        protected $array;
        
        protected function _before()
        {
            $this->array = ['products' => ['desk' => ['description' => 'Nice desk', 'price' => 100]]];
        }
        
        /**
        * @test
        */
        public function it_flattens_array_to_dot_notation()
        {
            $this->assertArrayHasKey('products.desk.price', Arr::dot($this->array));
        }
    
        /**
         * @test
         */
        public function it_flattens_array_to_dot_notation_with_prepended_text()
        {
            $this->assertArrayHasKey('prepend_products.desk.price', Arr::dot($this->array, 'prepend_'));
        }
        
        protected function _after()
        {
        }
    }
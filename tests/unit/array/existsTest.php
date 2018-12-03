<?php
    
    use GeordieJackson\Collection\Arr;
    
    class existsTest extends \Codeception\Test\Unit
    {
        /**
         * @var \UnitTester
         */
        protected $tester;
        protected $array;
        
        protected function _before()
        {
            $this->array = [
                'name' => 'Mary',
                'email' => 'mary@example.com',
                'salaried' => true,
                'cars' => [
                    'Audi' => 'saloon',
                    'Nissan' => 'crossover'
                ]
            ];
        }
        
        /**
        * @test
        */
        public function it_returns_true_when_key_exists()
        {
            $this->assertEquals(true, Arr::exists($this->array, 'email'));
            $this->assertEquals(true, Arr::exists($this->array['cars'], 'Audi'));
        }
        
        /**
         * @test
         */
        public function it_returns_false_when_key_is_absent()
        {
            $this->assertEquals(false, Arr::exists($this->array, 'key_not_in_array'));
        }
        
        protected function _after()
        {
        }
    }
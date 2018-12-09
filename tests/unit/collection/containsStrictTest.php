<?php
    
    namespace GeordieJackson\Collection\Tests\Collection;
    
    use GeordieJackson\Collection\Collection;
    
    class containsStrictTest extends \Codeception\Test\Unit
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
        public function strict_comparisons()
        {
            $c = new Collection([1, 3, 5, '02']);
            $this->assertTrue($c->containsStrict(1));
            $this->assertFalse($c->containsStrict(2));
            $this->assertTrue($c->containsStrict('02'));
            $this->assertTrue($c->containsStrict(function ($value) {
                return $value < 5;
            }));
            $this->assertFalse($c->containsStrict(function ($value) {
                return $value > 5;
            }));
            $c = new Collection([['v' => 1], ['v' => 3], ['v' => '04'], ['v' => 5]]);
            $this->assertTrue($c->containsStrict('v', 1));
            $this->assertFalse($c->containsStrict('v', 2));
            $this->assertFalse($c->containsStrict('v', 4));
            $this->assertTrue($c->containsStrict('v', '04'));
            $c = new Collection(['date', 'class', (object) ['foo' => 50], '']);
            $this->assertTrue($c->containsStrict('date'));
            $this->assertTrue($c->containsStrict('class'));
            $this->assertFalse($c->containsStrict('foo'));
            $this->assertFalse($c->containsStrict(null));
            $this->assertTrue($c->containsStrict(''));
        }
        
        protected function _after()
        {
        }
    }
<?php

class RouteFinderTests extends Orchestra\Testbench\TestCase
{

    /**
     * The Route Finder
     * @var RouteFinder
     */
    protected $finder;

    /**
     * Setup our shit
     */
    public function setUp()
    {
        parent::setUp();
        $this->products = \Mockery::mock('Davzie\ProductCatalog\Product');
        $this->categories = \Mockery::mock('Davzie\ProductCatalog\Category');
        $this->collections = \Mockery::mock('Davzie\ProductCatalog\Collection');
    }

    /**
     * Sort out my package providers
     * @return array
     */
    protected function getPackageProviders()
    {
        return array('Davzie\ProductCatalog\ProductCatalogServiceProvider');
    }

    /**
     * Test that the array of segments is a valid product
     * @return void
     */
    public function testIsProduct()
    {
        \Config::shouldReceive('get')->andReturn('product');
        $this->products->shouldReceive('getByUrl')->andReturn(true);
        $this->assertTrue( $this->getFinder()->isProduct( array( 'product' , 'ice' ) ) );
    }

    /**
     * Test that the array of segments is a valid product
     * @return void
     */
    public function testIsCollection()
    {
        \Config::shouldReceive('get')->andReturn('collection');
        $this->collections->shouldReceive('getByUrl')->andReturn(true);
        $this->assertTrue( $this->getFinder()->isCollection( array( 'collection' , 'ice' ) ) );
    }

    /**
     * Test that the array of segments is a valid product
     * @return void
     */
    public function testIsNotCollection()
    {
        \Config::shouldReceive('get')->andReturn('collection');
        $this->assertFalse( $this->getFinder()->isCollection( array( 'dasd' , 'ice' ) ) );
    }

    /**
     * Test that the array of segments is a valid product
     * @return void
     */
    public function testIsCollectionWithNoKey()
    {
        \Config::shouldReceive('get')->andReturn('');
        $this->collections->shouldReceive('getByUrl')->andReturn(true);
        $this->assertTrue( $this->getFinder()->isCollection( array( 'ice' ) ) );
    }

    /**
     * Test that the array of segments is a valid product where no key is required initially
     * @return void
     */
    public function testIsProductWithNoKey()
    {
        \Config::shouldReceive('get')->andReturn();
        $this->products->shouldReceive('getByUrl')->andReturn(true);
        $this->assertTrue( $this->getFinder()->isProduct( array('ice') ) );
    }

    /**
     * Test that if I pass a category, that if it's real we still have a product
     * @return void
     */
    public function testIsProductInCategory()
    {
        \Config::shouldReceive('get')->andReturn('product');
        $this->products->shouldReceive('getByUrl')->andReturn(true);
        $this->categories->shouldReceive('getByUrl')->andReturn(true);
        $this->assertTrue( $this->getFinder()->isProduct( array( 'product' , 'category' , 'ice' ) ) );
    }

    /**
     * Test that the array of segments is not a valid product
     * @return void
     */
    public function testIsNotProduct()
    {
        \Config::shouldReceive('get')->andReturn('fuck');
        $this->assertFalse( $this->getFinder()->isProduct( array( 'product' , 'ice' ) ) );
    }

    /**
     * Test that the category passed isn't an actual category,
     * this means there shouldn't be a matching product
     * @return void
     */
    public function testIsNotProductInCategory()
    {
        \Config::shouldReceive('get')->andReturn('product');
        $this->products->shouldReceive('getByUrl')->andReturn(true);
        $this->categories->shouldReceive('getByUrl')->andReturn(false);
        $this->assertFalse( $this->getFinder()->isProduct( array( 'product' , 'category' , 'ice' ) ) );
    }

    /**
     * Determine if the applied stuff is a category or not
     * @return void
     */
    public function testIsCategory()
    {
        \Config::shouldReceive('get')->andReturn('category');
        $this->categories->shouldReceive('getByUrl','children','where','first')->andReturn(true);
        $this->assertTrue( $this->getFinder()->isCategory( array( 'category' , 'my-category' ) ) );
    }

    /**
     * Determine if the applied stuff is a category or not
     * @return void
     */
    public function testIsNotCategory()
    {
        \Config::shouldReceive('get')->andReturn('category');
        $this->categories->shouldReceive('getByUrl','children','where','first')->andReturn(false);
        $this->assertFalse( $this->getFinder()->isCategory( array( 'category' , 'my-category' ) ) );
    }

    /**
     * Get the finder object back, all compiled and shit
     * @return RouteFinder
     */
    private function getFinder()
    {
        return new Davzie\ProductCatalog\RouteFinder( $this->products , $this->categories , $this->collections );
    }

}
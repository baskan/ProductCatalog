<?php namespace Davzie\ProductCatalog;

class RouteFinder
{

    /**
     * The products object
     * @var Product
     */
    protected $products;

    /**
     * The categories object
     * @var Category
     */
    protected $categories;

    /**
     * The Collections Object
     * @var Collection
     */
    protected $collection;

    /**
     * Store those lovely dependancies into class variables
     * @param Product    $product    The Product Object
     * @param Category   $category   The Category Object
     * @param Collection $collection The Collection Object
     */
    public function __construct( Product $product , Category $category , Collection $collection )
    {
        $this->products = $product;
        $this->categories = $category;
        $this->collections = $collection;
    }

    /**
     * Determine if the segments passed in equates to a product
     * @param  array   $segments Array of segments in order of how they are in the URL
     * @return boolean           True if it is a product
     */
    public function isProduct( array $segments )
    {
        if( !$segments )
            return false;

        // Lets do some special checking if there is a key to check for 
        if( $firstSegmentConfig = \Config::get('ProductCatalog::routing.product_segment') ){
            if( head($segments) !== $firstSegmentConfig )
                return false;

            array_shift($segments); // Remove the first element off our segments
        }

        if( count($segments) === 0)
            return false;

        // Check if the last segment is a valid product url
        if( $this->isProductUrl( last( $segments ) ) === false )
            return false;

        // The last segment is a valid product URL, lets eliminate that from error checking
        array_pop($segments);

        // The first key is valid as well as the last and nothing is left, its a valid product
        if( count($segments) === 0)
            return true;

        return $this->isValidCategoryHierarchy( $segments );
    }

    /**
     * Determine if the URL passed in is a valid category
     * @param  array   $segments The array of URL segments
     * @return boolean           Whether it's a category or not...
     */
    public function isCategory( array $segments )
    {
        if( !$segments )
            return false;

        // Lets do some special checking if there is a key to check for 
        if( $firstSegmentConfig = \Config::get('ProductCatalog::routing.category_segment') ){
            if( head($segments) !== $firstSegmentConfig )
                return false;

            array_shift($segments); // Remove the first element off our segments
        }

        return $this->isValidCategoryHierarchy( $segments );
    }

    /**
     * Determine if the URL segments passed are part of a collection URL
     * @param  array   $segments The segments from the URL
     * @return boolean           True if it's infact a collection
     */
    public function isCollection( array $segments )
    {
        if( !$segments )
            return false;

        // Lets do some special checking if there is a key to check for 
        if( $firstSegmentConfig = \Config::get('ProductCatalog::routing.collection_segment') ){
            if( head($segments) !== $firstSegmentConfig )
                return false;

            array_shift($segments); // Remove the first element off our segments
        }

        if( count($segments) === 0 )
            return false;

        // If the next element isn't a valid collection, it's not a valid URL
        if( !$this->isCollectionUrl( head($segments) ) )
            return false;

        array_shift($segments);

        // If there's stuff left, it means that it's part of a category, lets see if they are valid
        if( count($segments) > 0 )
            return $this->isValidCategoryHierarchy($segments);

        return true;
    }

    /**
     * Get the type of the URL that we have
     * @param  array  $segments The URL segments
     * @return string   
     */
    public function getType( array $segments )
    {
        if( $this->isProduct($segments) )
            return 'product';

        if( $this->isCategory($segments) )
            return 'category';

        if( $this->isCollection($segments) )
            return 'collection';

        return null;
    }

    /**
     * Determine if the URL is valid at all
     * @param  array   $segments Array of segments in order of how they are in the URL
     * @return boolean           False if the url isn't valid at all...
     */
    public function isValid( array $segments )
    {
        $valid = false;

        if( $this->isProduct($segments) )
            $valid = true;

        if( $this->isCategory($segments) )
            $valid = true;

        if( $this->isCollection($segments) )
            $valid = true;

        return $valid;
    }

    /**
     * Determine if the array of segments is a valid set of category URLs.
     * Also check the heirachy of these
     * @param  array   $segments The array of URL segments
     * @return boolean           Whether or not the category hierarchy is valid
     */
    protected function isValidCategoryHierarchy( array $segments )
    {
        if(!$segments)
            return false;

        $topCategory = $this->getCategoryByUrl( head($segments) );
        array_shift($segments); // Pop off that first element, we have that noe

        if( !$topCategory )
            return false;

        // Check that everything in-between is a valid category URL
        foreach($segments as $segment){

            $topCategory = $topCategory->children()->where('url','=',$segment)->first();
            if( !$topCategory )
                return false;

        }

        return true;
    }

    /**
     * Determine if the product string passed in is a product URL
     * @param  string  $url The URL string
     * @return boolean      If true, then it's indeed a product
     */
    protected function isProductUrl( $url )
    {
        $product = $this->products->getByUrl($url);
        
        if($product)
            return true;

        return false;
    }

    /**
     * Determine if the category string passed in is a category URL
     * @param  string  $url The URL string
     * @return boolean      If true, then it's indeed a category
     */
    protected function isCategoryUrl( $url )
    {
        $category = $this->getCategoryByUrl($url);
        
        if($category)
            return true;

        return false;
    }

    /**
     * Determine if the collection string passed in is a collection URL
     * @param  string  $url The URL string
     * @return boolean      If true, then it's indeed a collection
     */
    protected function isCollectionUrl( $url )
    {
        $collection = $this->collections->getByUrl($url);
        
        if($collection)
            return true;

        return false;
    }

    /**
     * Get a Category by it's URL
     * @param  string $url The URL of the category
     * @return Category
     */
    protected function getCategoryByUrl( $url )
    {
        return $this->categories->getByUrl($url);
    }

}
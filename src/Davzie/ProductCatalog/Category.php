<?php
namespace Davzie\ProductCatalog;
use Davzie\ProductCatalog\Collection;
use Davzie\ProductCatalog\Category;

/**
 * Lets tell our interface what methods we want to ensure are on the class that implements this contract
 */
interface Category {

    /**
     * Get all in the system
     * @return Eloquent
     */
    public function getAll();

    /**
     * Get a category by a URL key
     * @param  string $url Get the category if the URL passed in matches it
     * @return Eloquent
     */
    public function getByUrl( $url );

    /**
     * Get all subcategories, ie, everything in the second level (not top level)
     * @return Collection
     */
    public function getAllSubcategories();

    /**
     * Get the full URL of the category
     * @return string
     */
    public function getFullUrlAttribute();

    /**
     * Get the active categories
     * @return Eloquent
     */
    public function scopeactiveCategories($query);

    /**
     * Get a category by its slug
     * @param  string $slug The Category's Slug
     * @return Eloquent    The category retrieved
     */
    public function getBySlug( $slug );

    /**
     * Get the parent category if it exists
     * @return Eloquent
     */
    public function parent();

    /**
     * Get all products associated with a collection and category
     * @return Eloquent
     */
    public function filterByCollection( Category $category , Collection $collection );

    /**
     * Get the child categories if they exists
     * @return Eloquent
     */
    public function children();

    /**
     * The products available in this category
     * @return Eloquent
     */
    public function products();

    /**
     * Delete a category by its category ID
     * @param  integer $id The Category ID
     * @return boolean
     */
    public function deleteById( $id );

    /**
     * The media object to get the uploads available
     * @return Eloquent
     */
    public function media();

    /**
     * Get categories that do not have a parent category, ie. top level
     * @return Eloquent
     */
    public function getTopLevel( $id );

    /**
     * Determine whether or not the category in question has children / sub categories
     * @return boolean True if it does, false if it doesn't
     */
    public function hasChildren();

    /**
     * Get the thumbnail image associated with this category
     * @return Upload   The upload object
     */
    public function getThumbnailImage();

    /**
     * Get the main image of the category
     * @return Eloquent
     */
    public function getMainImage();

    /**
     * Determine whether or not this category should show filters only
     * @return boolean True if the category is filterable
     */
    public function isFilterable();

    /**
     * Sometimes it may be necessary to retrieve all products including those in child categories, this should do that.
     * @return Collection
     */
    public function getAllProductsIncludingChildren();

    /**
     * The numerical level of the category in heirachy. Level 0 is the highest
     * @return integer
     */
    public function level();

    /**
     * Sometimes we want to indicate what level we're at in dropdowns or in the backend menu, this produces counts of characters and a final character
     * to show this, similar to -> or ---> 
     * @param  string $indicator The indicator (in the example above the dash)
     * @param  string $final     The final arrow if required ( could be > as above )
     * @return string
     */
    public function getLevelIndicator( $indicator = '-' , $final = '' );

    /**
     * Get the TRs for the admin area
     * @return View
     */
    public function displayOrderedAdminHTML();

    /**
     * Get the list of flattened heirachial categories available to us
     * @return array
     */
    public function getFlattenedCategories();

    /**
     * Get all available collections in this category
     * @return Collection
     */
    public function getCollections( Category $category );

}
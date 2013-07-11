<?php
namespace Davzie\ProductCatalog;

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
     * Get the full URL of the category
     * @return string
     */
    public function getFullUrl();

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
     * Get categories that do not have a parent category, ie. top level
     * @return Eloquent
     */
    public function getTopLevel( $id );

    /**
     * Determine whether or not the category in question has children / sub categories
     * @return boolean True if it does, false if it doesn't
     */
    public function hasChildren();

}
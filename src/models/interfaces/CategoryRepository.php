<?php
namespace Davzie\ProductCatalog\Models\Interfaces;

/**
 * Lets tell our interface what methods we want to ensure are on the class that implements this contract
 */
interface CategoryRepository {

    /**
     * Get all in the system
     * @return Eloquent
     */
    public function getAll();

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

}
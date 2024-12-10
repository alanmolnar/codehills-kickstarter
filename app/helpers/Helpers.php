<?php
/**
 * Helpers Class
 *
 * This file contains the Helpers class which provides utility methods for the Codehills Kickstarter theme.
 * It includes methods for compacting block details into an object for easier access and other helper functions.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage Codehills Kickstarter Theme
 */

namespace CodehillsKickstarter\Helpers;

// Prevent direct access to this file from url
defined( 'WPINC' ) || exit;

class Helpers {
    /**
     * Compact the block details into an object
     * 
     * This method compacts the block details into an object for easier access.
     * 
     * @since 2.0.0
     * @param array $block_details
     * @return object
     */
    public static function collect( $block_details = [] )
    {
        // Set empty array object
        $collection = [];

        foreach ( $block_details as $key => $data ) :
            $collection[$key] = $data;
        endforeach;

        // Return the collection as object
        return (object) $collection;
    }
}
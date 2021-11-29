<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/googlemaps
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

// ESTATEMANAGER
$GLOBALS['TL_ESTATEMANAGER_ADDONS'][] = array('ContaoEstateManager\GoogleMaps', 'AddonManager');

if(ContaoEstateManager\GoogleMaps\AddonManager::valid()) {
    // Models
    $GLOBALS['TL_MODELS']['tl_geo_postal_code'] = 'ContaoEstateManager\GoogleMaps\GeoPostalCodeModel';

    // Front end modules
    $GLOBALS['FE_MOD']['estatemanager']['realEstateGoogleMap'] = 'ContaoEstateManager\GoogleMaps\ModuleRealEstateGoogleMap';

    // Add expose module
    $GLOBALS['CEM_FE_EXPOSE_MOD']['media']['googleMap'] = 'ContaoEstateManager\GoogleMaps\ExposeModuleGoogleMap';

    // Hooks
    //$GLOBALS['TL_HOOKS']['beforeRealEstateImport'][]   = array('ContaoEstateManager\\GoogleMaps\\PostalCode', 'determinePostalCodeGeoData');
}

<?php

declare(strict_types=1);

/*
 * This file is part of Contao EstateManager.
 *
 * @see        https://www.contao-estatemanager.com/
 * @source     https://github.com/contao-estatemanager/google-maps
 * @copyright  Copyright (c) 2021 Oveleon GbR (https://www.oveleon.de)
 * @license    https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

// ESTATEMANAGER
$GLOBALS['TL_ESTATEMANAGER_ADDONS'][] = ['ContaoEstateManager\GoogleMaps', 'AddonManager'];

use ContaoEstateManager\GoogleMaps\AddonManager;

if (AddonManager::valid())
{
    // Models
    $GLOBALS['TL_MODELS']['tl_geo_postal_code'] = 'ContaoEstateManager\GoogleMaps\GeoPostalCodeModel';

    // Front end modules
    $GLOBALS['FE_MOD']['estatemanager']['realEstateGoogleMap'] = 'ContaoEstateManager\GoogleMaps\ModuleRealEstateGoogleMap';

    // Add expose module
    $GLOBALS['FE_EXPOSE_MOD']['media']['googleMap'] = 'ContaoEstateManager\GoogleMaps\ExposeModuleGoogleMap';

    // Hooks
    //$GLOBALS['TL_HOOKS']['beforeRealEstateImport'][]   = array('ContaoEstateManager\\GoogleMaps\\PostalCode', 'determinePostalCodeGeoData');
}

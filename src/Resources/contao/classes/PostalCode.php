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

namespace ContaoEstateManager\GoogleMaps;

use Contao\Controller;

class PostalCode extends Controller
{
    /**
     * Determine postal code.
     *
     * @param $objRealEstate
     * @param $context
     */
    public function determinePostalCodeGeoData(&$objRealEstate, $context): void
    {
        if (empty($objRealEstate->plz))
        {
            return;
        }

        $objGeoPostalCode = GeoPostalCodeModel::findOneByCode($objRealEstate->plz);

        if (null === $objGeoPostalCode)
        {
        }

        $objRealEstate->breitengrad = $objGeoPostalCode->latitude;
        $objRealEstate->laengengrad = $objGeoPostalCode->longitude;
    }
}

<?php

namespace Elogic\Internship\Api;

interface GeoCodeInterface
{
    /**
     * @param string $address
     * @return mixed
     */
    public function getCoordinates(string $address);
}

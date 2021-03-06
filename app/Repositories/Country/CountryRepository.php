<?php

namespace Vanguard\Repositories\Country;

interface CountryRepository
{
    /**
     * Create $key => $value array for all available countries.
     *
     * @param string $column
     * @param string $key
     * @return mixed
     */
    public function lists($column = 'name', $key = 'id');
    
    /**
     * Create $key => $value array for all available countries.
     *
     * @param string $column
     * @param string $key
     * @return mixed
     */
    public function lists1($column='calling_code');
    
    public function getCountryISDCode($countryid);
}
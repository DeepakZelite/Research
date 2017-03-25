<?php

namespace Vanguard\Repositories\Country;

use Vanguard\Country;

class EloquentCountry implements CountryRepository
{
    /**
     * {@inheritdoc}
     */
    public function lists($column = 'name', $key = 'id')
    {
        return Country::orderBy('name')->lists($column, $key);
    }
    
    /**
     * {@inheritdoc}
     */
    public function lists1($column='calling_code')
    {
    	return Country::distinct()->orderBy('calling_code')->lists($column); //distinct()->get(['calling_code']);
    }
}
<?php

namespace Vanguard\Repositories\Code;

interface CodeRepository
{
    /**
     * Create $key => $value array for all available countries.
     *
     * @param string $column
     * @param string $key
     * @return mixed
     */
    public function lists($column = 'description', $key = 'code');
    public function lists1($column = 'description', $key = 'code');
 }
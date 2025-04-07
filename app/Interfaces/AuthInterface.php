<?php

namespace App\Interfaces;

interface AuthInterface
{
    public function login($request);

    public function user($request);

    public function logout($request);
}

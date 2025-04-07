<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\StatusService;

class StatusController extends Controller
{
    protected $service;

    public function __construct(StatusService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->getAllStatuses();
    }
}

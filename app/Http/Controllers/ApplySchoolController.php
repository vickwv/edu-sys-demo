<?php


namespace App\Http\Controllers;

use App\Http\Requests\CreateApplySchoolRequest;
use App\Http\Services\ApplySchoolService;

class ApplySchoolController extends Controller
{

    /**
     * @var ApplySchoolService $service
     */
    protected $service;

    public function __construct(ApplySchoolService $applySchoolService) {
        $this->service = $applySchoolService;
    }

    public function create(CreateApplySchoolRequest $request) {
        return $this->success("success", $this->service->create($request->validated()));
    }

}
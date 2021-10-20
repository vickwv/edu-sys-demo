<?php


namespace App\Http\Controllers;

use App\Http\Requests\CreateApplySchoolRequest;
use App\Http\Services\ApplySchoolService;

/**
 * 功能：申请单
 *
 * @author: stevenv
 * @date: 2021-10-15
 **/
class ApplySchoolController extends Controller
{
    /**
     * @var ApplySchoolService $service
     */
    protected $service;

    public function __construct(ApplySchoolService $applySchoolService) {
        $this->service = $applySchoolService;
    }

    /**
     * 功能：创建申请单
     *
     * @author: stevenv
     * @date: 2021-10-15
     **/
    public function create(CreateApplySchoolRequest $request) {
        return $this->success("success", $this->service->create($request->validated()));
    }

}
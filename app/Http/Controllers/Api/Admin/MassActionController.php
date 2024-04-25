<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\SystemHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Api\Admin\MassActionRepository;
use App\Http\Requests\Api\Admin\MassAction\massEdit;
use App\Http\Requests\Api\Admin\MassAction\massDelete;
use App\Helpers\ExceptionHandlerHelper;

class MassActionController extends Controller
{
    protected $massActionRepository;

    public function __construct(MassActionRepository $massActionRepository)
    {
        $this->massActionRepository = $massActionRepository;
    }

    public function massEdit(massEdit $request)
    {
        return ExceptionHandlerHelper::tryCatch(function () use ($request) {
            $tableName = $request->input('table_name');
            // Get the fillable attributes for the specified table
            $fillableAttributes = app(SystemHelper::tableToModel($tableName))->getFillable();
            // Pass the fillable attributes along with the validated data to the repository
            $action = $this->massActionRepository->massEdit(
                $request->validated(),
                $request->only($fillableAttributes)
            );
            return $this->sendResponse($action, 'Admin password updated successfully');
        });
    }


    public function massDelete(massDelete $request)
    {
        return ExceptionHandlerHelper::tryCatch(function () use ($request) {
            $action = $this->massActionRepository->massDelete($request->validated());
            return $this->sendResponse($action, 'Admin password updated successfully');
        });
    }
}

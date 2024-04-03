<?php

namespace App\Repositories\Api\Terminal;

use App\Helpers\PaginationHelper;
use App\Interfaces\Api\Terminal\SymbelInterface;
use App\Models\SymbelGroup;
use Illuminate\Database\Eloquent\Model;

class SymbelRepository implements SymbelInterface
{
    private $model;

    public function __construct()
    {
        $this->model = new SymbelGroup();
    }

    // TODO: Get all symbels.
    public function getAllSymbels()
    {
        $symbelGroup = $this->model->with('settings')->get();
        return $symbelGroup;
    }

}

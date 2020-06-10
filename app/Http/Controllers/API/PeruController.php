<?php

namespace App\Http\Controllers\API;

use App\Department;
use App\Http\Controllers\Controller;
use App\Province;

class PeruController extends Controller
{
    public function departments()
    {
        return Department::orderBy('name', 'ASC')->get(['id', 'name']);
    }
    public function provinces($id)
    {
        $department = Department::find($id);
        return $department->provinces()->orderBy('name', 'ASC')->get(['id', 'name']);
    }

    public function districts($id)
    {
        $province = Province::find($id);
        return $province->districts()->orderBy('name', 'ASC')->get();
    }

}

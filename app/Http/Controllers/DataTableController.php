<?php

namespace App\Http\Controllers;

use App\Helpers\DataTablesManager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DataTableController extends Controller
{
    public function datatable(Request $request)
    {
        $type = Str::camel($request->type);
        return $request->has('type') ? (new DataTablesManager)->$type($request) : abort(404);
    }
}

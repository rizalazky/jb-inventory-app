<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\PermissionDataTable;

class PermissionController extends Controller
{
    //
    public function index(PermissionDataTable $dataTable){
       
        return $dataTable->render('permission.index');
    }
}

<?php

namespace App\Http\Controllers\Users;

use App\DataTables\Admin\UserEventsDatatable;
use App\DataTables\Admin\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        $page_title = 'Users List';

        return $dataTable->render('admin.users.users', ['page_title' => $page_title]);
    }

    public function show(Request $request, $id)
    {
        $user = User::with('mainWallet')->find($id);
        $dataTable = new UserEventsDatatable($user);

        return $dataTable->render('admin.users.show', compact('user'));
    }
}

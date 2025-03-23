<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('pages/home');
    }
    public function noAccess()
    {
        return view('errors/no_access'); // Hiển thị trang báo lỗi quyền truy cập
    }
}

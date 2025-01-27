<?php

namespace App\Controllers;

class QuanLyBoMon extends BaseController
{
    public function index(): string
    {
        return view('quan-ly-bo-mon/index');
    }
}

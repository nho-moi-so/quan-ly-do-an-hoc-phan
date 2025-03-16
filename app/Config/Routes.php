<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
// Khoa
$routes->get('/quan-ly-khoa', 'QuanLyKhoa::index');
$routes->post('quan-ly-khoa/add-khoa', 'QuanLyKhoa::add');
$routes->post('quan-ly-khoa/edit-khoa', 'QuanLyKhoa::edit');
$routes->get('quan-ly-khoa/delete-khoa/(:num)', 'QuanLyKhoa::delete/$1');

// Bộ Môn
$routes->get('quan-ly-bo-mon/(:num)', 'QuanLyBoMon::index/$1');
$routes->get('quan-ly-bo-mon', 'QuanLyBoMon::index');
$routes->post('quan-ly-bo-mon/add-bo-mon/(:num)', 'QuanLyBoMon::add/$1');
$routes->post('quan-ly-bo-mon/add-bo-mon', 'QuanLyBoMon::add');
$routes->post('quan-ly-bo-mon/edit-bo-mon', 'QuanLyBoMon::edit');
$routes->get('quan-ly-bo-mon/delete-bo-mon/(:num)', 'QuanLyBoMon::delete/$1');

// Ngành
$routes->get('quan-ly-nganh/(:num)', 'QuanLyNganh::index/$1');
$routes->get('quan-ly-nganh', 'QuanLyNganh::index');
$routes->post('quan-ly-nganh/add-nganh/(:num)', 'QuanLyNganh::add/$1');
$routes->post('quan-ly-nganh/add-nganh', 'QuanLyNganh::add');
$routes->post('quan-ly-nganh/edit-nganh', 'QuanLyNganh::edit');
$routes->get('quan-ly-nganh/delete-nganh/(:num)', 'QuanLyNganh::delete/$1');

//Lớp
$routes->get('quan-ly-lop/(:num)', 'QuanLyLop::index/$1');
$routes->get('/quan-ly-lop', 'QuanLyLop::index');
$routes->post('quan-ly-lop/add-lop/(:num)', 'QuanLyLop::add/$1');
$routes->post('quan-ly-lop/add-lop', 'QuanLyLop::add');
$routes->post('quan-ly-lop/edit-lop', 'QuanLyLop::edit');
$routes->get('quan-ly-lop/delete-lop/(:num)', 'QuanLyLop::delete/$1');

//Giảng Viên
$routes->group('GiangVien', ['filter' => 'auth'], function ($routes) {
$routes->get('/quan-ly-giang-vien', 'QuanLyGiangVien::index');
$routes->post('quan-ly-giang-vien/add-giang-vien', 'QuanLyGiangVien::add');
$routes->post('quan-ly-giang-vien/edit-giang-vien', 'QuanLyGiangVien::edit');
$routes->get('quan-ly-giang-vien/delete-giang-vien/(:num)', 'QuanLyGiangVien::delete/$1');
});

//Sinh Viên
$routes->group('SinhVien', ['filter' => 'auth'], function ($routes) {
$routes->get('/quan-ly-sinh-vien', 'QuanLySinhVien::index');
$routes->post('quan-ly-sinh-vien/add-sinh-vien', 'QuanLySinhVien::add');
$routes->post('quan-ly-sinh-vien/edit-sinh-vien', 'QuanLySinhVien::edit');
$routes->get('quan-ly-sinh-vien/delete-sinh-vien/(:num)', 'QuanLySinhVien::delete/$1');
});

//Đề Tài
$routes->get('/quan-ly-de-tai', 'QuanLyDeTai::index');
$routes->post('quan-ly-de-tai/add-de-tai', 'QuanLyDeTai::add');
$routes->post('quan-ly-de-tai/edit-de-tai', 'QuanLyDeTai::edit');
$routes->get('quan-ly-de-tai/delete-de-tai/(:num)', 'QuanLyDeTai::delete/$1');
$routes->get('/quan-ly-de-tai/timkiem', 'QuanLyDeTai::timkiem');
// $routes->get('/quan-ly-de-tai/xem-danh-sach-dang-ki/(:num)', 'QuanLyDeTai::xemdanhsachdangki/$1');


//Đồ Án
$routes->get('/quan-ly-do-an', 'QuanLyDoAn::index');
$routes->post('quan-ly-do-an/add-do-an', 'QuanLyDoAn::add');
$routes->post('quan-ly-do-an/edit-do-an', 'QuanLyDoAn::edit');
$routes->get('quan-ly-do-an/delete-do-an/(:num)', 'QuanLyDoAn::delete/$1');
$routes->post('quan-ly-do-an/dang-ki-do-an', 'QuanLyDoAn::dangkidoan');
$routes->post('quan-ly-do-an/cap-nhat-trang-thai', 'QuanLyDoAn::capNhatTrangThai');
$routes->post('quan-ly-do-an/tu-choi', 'QuanLyDoAn::tuchoi');
$routes->post('quan-ly-do-an/huy-dang-ki', 'QuanLyDoAn::huy');
$routes->get('/quan-ly-do-an/chi-tiet-do-an/(:num)', 'QuanLyDoAn::chitiet/$1');
$routes->post('quan-ly-do-an/luu', 'QuanLyDoAn::luu');
$routes->post('quan-ly-do-an/quaylai', 'QuanLyDoAn::quaylai');

//Login

$routes->get('login', 'User::login');
$routes->post('user/doLogin', 'User::doLogin');
$routes->get('logout', 'User::logout');

if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
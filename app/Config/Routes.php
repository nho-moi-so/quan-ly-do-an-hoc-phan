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
$routes->post('quan-ly-khoa/delete-khoa', 'QuanLyKhoa::delete');
// Bộ Môn
$routes->get('/quan-ly-bo-mon', 'QuanLyBoMon::index');


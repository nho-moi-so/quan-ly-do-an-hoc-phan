<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $this->renderSection('title') ?></title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
    <link rel="stylesheet" href="<?= base_url('assets/lib/coreui-5.2.0/css/coreui.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/lib/fontawesome/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
        <div class="sidebar-header border-bottom">
            <div class="sidebar-brand">
                LOGO
            </div>
            <button class="btn-close d-lg-none" type="button" data-coreui-dismiss="offcanvas" data-coreui-theme="dark"
                aria-label="Close"
                onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"></button>
        </div>
        <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
            <li class="nav-item"><a class="nav-link" href="/">
                    <i class="fa-solid fa-house"></i>&nbsp; Trang Chủ</a>
            </li>

            <li class="nav-item"><a class="nav-link" href="#"> Thống Kê Báo Cáo</a>
            </li>

            <li class="nav-group">
                <a class="nav-link nav-group-toggle" href="#">
                    Quản Lý Đào Tạo</a>
                <ul class="nav-group-items compact">
                    <li class="nav-item"><a class="nav-link" href="/quan-ly-khoa"><span class="nav-icon"><span
                                    class="nav-icon-bullet"></span></span> Quản Lý Khoa</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" href="/quan-ly-bo-mon"><span class="nav-icon"><span
                                    class="nav-icon-bullet"></span></span> Quản Lý Bộ Môn</a></li>
                    <li class="nav-item"><a class="nav-link" href="/quan-ly-nganh"><span class="nav-icon"><span
                                    class="nav-icon-bullet"></span></span> Quản Lý Ngành</a></li>
                    <li class="nav-item"><a class="nav-link" href="/quan-ly-lop"><span class="nav-icon"><span
                                    class="nav-icon-bullet"></span></span> Quản Lý Lớp</a></li> -->

                </ul>
            </li>
            <li class="nav-group">
                <a class="nav-link nav-group-toggle" href="#">
                    Quản Lý Nhân Sự</a>
                <ul class="nav-group-items compact">
                    <li class="nav-item"><a class="nav-link" href="/quan-ly-giang-vien"><span class="nav-icon"><span
                                    class="nav-icon-bullet"></span></span> Quản Lý Giảng Viên </a></li>
                    <li class="nav-item"><a class="nav-link" href="/quan-ly-sinh-vien"><span class="nav-icon"><span
                                    class="nav-icon-bullet"></span></span> Quản Lý Sinh Viên</a></li>


                </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="/quan-ly-de-tai">Quản Lý Đề Tài</a>
            </li>
            <li class="nav-item"><a class="nav-link" href="/quan-ly-do-an">Quản Lý Đồ Án</a>
            </li>



            <div class="sidebar-footer border-top d-none d-md-flex">
                <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
            </div>
    </div>
    <div class="wrapper d-flex flex-column justify-content-between min-vh-100">
        <header class="header header-sticky p-0 mb-4">
            <div class="container-fluid border-bottom px-4">
                <button class="header-toggler" type="button"
                    onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"
                    style="margin-inline-start: -14px;">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <ul class="header-nav">
                    <li class="nav-item dropdown">
                      
                        <a class="nav-link py-0 pe-0" data-coreui-toggle="dropdown" href="#"
                            role="button" aria-haspopup="true" aria-expanded="false">
                            <span><?= session()->get('hoTen')?></span>
                            |
                            <span><?= session()->get('role')?></span>
                            <div class="avatar avatar-md">
                                <img class="avatar-img" src="assets/images/default-user.webp"alt="user@email.com">
                            </div>
                           
                        </a>
                        <div class="dropdown-menu dropdown-menu-end pt-0">
                            <div
                                class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold rounded-top mb-2">
                                Account
                            </div>
                            <a class="dropdown-item" href="#">
                                <a class="dropdown-item" href="#">
                                    Profile</a><a class="dropdown-item" href="#">
                                    Settings</a><a class="dropdown-item" href="#">
                                    Projects<span class="badge badge-sm bg-primary ms-2"></span></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="">
                                    Lock Account</a><a class="dropdown-item" href="<?= base_url('logout') ?>">
                                    Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="container-fluid px-4">
                <!-- <nav aria-label="breadcrumb">
                    <ol class="breadcrumb my-0">
                        <li class="breadcrumb-item"><a href="#">Home</a>
                        </li>
                        <li class="breadcrumb-item active"><span>Dashboard</span>
                        </li>
                    </ol>
                </nav> -->
            </div>
        </header>
        <main class="content flex-grow-1 mb-4">
            <?= $this->renderSection("content") ?>
        </main>
        <footer class="footer px-4">
            <div class="container">
                <p class="text-center mb-0">
                    &copy; Copyright by Ngọc Ngọc.
                </p>
            </div>
        </footer>
    </div>

    <!-- Script Section -->
    <script src="<?= base_url('assets/lib/coreui-5.2.0/js/coreui.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/lib/fontawesome/js/all.min.js') ?>"></script>
    <script>
        const header = document.querySelector('header.header');

        document.addEventListener('scroll', () => {
            if (header) {
                header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
            }
        });
    </script>
    <?= $this->renderSection("scripts") ?>
</body>

</html>
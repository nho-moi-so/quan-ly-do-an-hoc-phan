<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // Lấy thông tin role từ session
        $userRole = $session->get('role'); // Giả sử role lưu trong session khi đăng nhập
        
        if (!$userRole) {
            return redirect()->to('/login')->with('error', 'Bạn cần đăng nhập!');
        }

        // Kiểm tra xem role của user có trong danh sách $arguments không
        if (!in_array($userRole, $arguments)) {
            return redirect()->to('/no-access')->with('error', 'Bạn không có quyền truy cập!');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Không cần xử lý gì sau khi request
    }
}

?>
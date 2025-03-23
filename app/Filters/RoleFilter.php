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

        $userRole = $session->get('role');
        
        if (!$userRole) {
            return redirect()->to('/login')->with('message', 'Vui lòng đăng nhập!');
        }

        if (empty($arguments)) {
            return;
        }

        if (!in_array($userRole, $arguments)) {
            return redirect()->to('/no-access')->with('message', 'Bạn không có quyền truy cập!');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
       
    }
}

?>
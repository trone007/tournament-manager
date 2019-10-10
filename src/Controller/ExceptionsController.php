<?php
namespace Src\Controller;

use Core\Controller;

class ExceptionsController extends Controller
{
    /**
     * render page 404
     */
    public function page404()
    {
        http_response_code(404);
        $this->render('404');
    }

    /**
     * render page 403
     */
    public function page403()
    {
        http_response_code(403);
        $this->render('403');
    }

    /**
     * render page 405
     */
    public function page405()
    {
        http_response_code(405);
        $this->render('405');
    }
}
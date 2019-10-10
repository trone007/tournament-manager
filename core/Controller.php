<?php
namespace Core;

use Doctrine\ORM\EntityManagerInterface;
use Http\Request;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Controller
{
    /** @var array  */
    private $vars=[];

    /** @var Environment */
    private $twig;

    /** @var Request|null  */
    protected $request;

    /** @var EntityManagerInterface  */
    protected $entityManager;

    /**
     * Controller constructor.
     * @param Environment $twig
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(Environment $twig, EntityManagerInterface $entityManager)
    {
        $this->request = Request::getInstance();
        $this->twig = $twig;
        $this->entityManager = $entityManager;
    }

    /**
     * rendering template
     * @param $filename
     * @param array $variables
     */
    public function render($filename, $variables = [])
    {
        extract($this->vars);

        try {
            $className = (new \ReflectionClass($this))->getShortName();

            $path = sprintf('%s/%s.html.twig',
                ucfirst(str_replace('Controller', '', $className)),
                $filename);

            $variables['session'] = new SessionHelper();
            echo $this->twig->render($path, $variables);
        } catch (LoaderError $e) {
            error_log($e->getMessage());
        } catch (RuntimeError $e) {
            error_log($e->getMessage());
        } catch (SyntaxError $e) {
            error_log($e->getMessage());
        } catch (\ReflectionException $e) {
            error_log($e->getMessage());
        }
    }

    /**
     * rendering json
     * @param mixed $data
     * @return false|string
     */
    public function renderJson($data, $status = 200)
    {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => $status, 'results' => $data
        ], JSON_UNESCAPED_UNICODE);
    }

    /**
     * base redirect method
     * @param string $route
     * @param int $statusCode
     */
    public function redirect(string $route, $statusCode = 303)
    {
        header(sprintf('Location: %s', $route), true, $statusCode);
        die();
    }

}

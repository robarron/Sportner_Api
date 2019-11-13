<?php

namespace App\Service;

use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class ApiService
{
    /**
     * @param array $data
     * @param int $statusCode
     * @param array $headers
     * @param string $format
     *
     * @return View
     */
    public function createFosRestView(array $data, $statusCode = Response::HTTP_OK, array $headers = [], $format = 'json')
    {
        $finalData = ['result' => $data];
        $view = View::create($finalData, $statusCode, $headers);
        $view->setFormat($format);

        return $view;
    }
}
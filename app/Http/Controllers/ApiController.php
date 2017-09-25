<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class ApiController.
 *
 *
 * @SWG\Swagger(
 *     basePath="",
 *     host="api.ciayo.com",
 *     schemes={"https"},
 *     @SWG\Info(
 *         version="1.0",
 *         title="Ciayo API",
 *         description="Aplication Programming Interface (API) ciayo.com.",
 *         @SWG\Contact(
 *              name="Backend Ciayo",
 *              email="backend@dragoncapital.center"
 *         )
 *     )
 * )
 */
class ApiController extends Controller
{
    /**
     * @var int
     */
    #protected $statusCode = SymfonyResponse::HTTP_OK;

    protected $request;

    protected $response;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param string $content
     * @param int    $status
     * @param array  $headers
     *
     *
     * @author Fathur Rohman <fathur@dragoncapital.center>
     * @return \App\Repositories\Response|\Symfony\Component\HttpFoundation\Response
     */
    protected function response($content = '', $status = 200, array $headers = [])
    {

        $factory = new \App\Repositories\Response($this->request);

        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($content, $status, $headers);
    }
}

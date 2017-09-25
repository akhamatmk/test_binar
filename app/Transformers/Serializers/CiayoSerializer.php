<?php

namespace App\Transformers\Serializers;

use App\Repositories\CursorPagination;
use Carbon\Carbon;
use Illuminate\Http\Request;
use League\Fractal\Pagination\CursorInterface;
use League\Fractal\Pagination\PaginatorInterface;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\ResourceInterface;
use League\Fractal\Serializer\SerializerAbstract;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class CiayoSerializer extends SerializerAbstract
{
    /**
     * @var array
     */
    protected $ciayoAttribute;

    /**
     * @var Collection|\Illuminate\Support\Collection|array
     */
    protected $data;

    /**
     * @var Request
     */
    protected $request;

    /**
     * CiayoSerializer constructor.
     *
     * @param       $data
     * @param array $ciayoAttribute
     * @param       $request
     */
    public function __construct($data, array $ciayoAttribute, $request)
    {
        $this->data = $data;

        $this->ciayoAttribute = $ciayoAttribute;

        $this->request = $request;
    }

    /**
     * Serialize a collection.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        if($this->request->has('cursor')) {
            $cursorCount = array_key_exists('count', $this->request['cursor']) ? $this->request['cursor']['count'] : CursorPagination::$cursorCount;

            if (!is_null($this->data->getCursor())) {
                if ($this->data->getCursor()->getCount() == ($cursorCount + 1)) {
                    array_pop($data);
                }
            }

            return [
                'status' => [
                    'error'   => array_key_exists('status.error', $this->ciayoAttribute) ? $this->ciayoAttribute['status.error'] : false,
                    'message' => array_key_exists('status.message', $this->ciayoAttribute) ? $this->ciayoAttribute['status.message'] : null,
                    'code'    => array_key_exists('status.code', $this->ciayoAttribute) ? $this->ciayoAttribute['status.code'] : SymfonyResponse::HTTP_OK,
                ],
                'data'   => $data
            ];
        } else {
            return [
                'status' => [
                    'error'   => array_key_exists('status.error', $this->ciayoAttribute) ? $this->ciayoAttribute['status.error'] : false,
                    'message' => array_key_exists('status.message', $this->ciayoAttribute) ? $this->ciayoAttribute['status.message'] : null,
                    'code'    => array_key_exists('status.code', $this->ciayoAttribute) ? $this->ciayoAttribute['status.code'] : SymfonyResponse::HTTP_OK,
                ],
                'data'   => $data
            ];
        }
    }

    /**
     * Serialize an item.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function item($resourceKey, array $data)
    {

        return [
            'status' => [
                'error'   => false,
                'message' => null,
                'code'    => SymfonyResponse::HTTP_OK,
            ],
            'data' => $data
        ];
    }

    /**
     * Serialize the included data.
     *
     * @param ResourceInterface $resource
     * @param array             $data
     *
     * @return array
     */
    public function includedData(ResourceInterface $resource, array $data)
    {
        return $data;
    }

    /**
     * Serialize the meta.
     *
     * @param array $meta
     *
     * @return array
     */
    public function meta(array $meta)
    {
        $metaCiayo = [
            'more'      => $this->isMore(),
            'token'     => array_key_exists('meta.token', $this->ciayoAttribute)? $this->ciayoAttribute['meta.token'] : null,
            'language'  => array_key_exists('meta.language', $this->ciayoAttribute)? $this->ciayoAttribute['meta.language'] : null,
            'timestamp' => array_key_exists('meta.timestamp', $this->ciayoAttribute) ? $this->ciayoAttribute['meta.timestamp'] : Carbon::now()->timestamp
        ];

        if(env('APP_DEBUG') AND env('APP_ENV') != 'testing')
            $metaCiayo['debug'] = \DB::getQueryLog();

        return ['meta' => array_merge($meta, $metaCiayo)];
    }

    /**
     * Serialize the paginator.
     *
     * @param PaginatorInterface $paginator
     *
     * @return array
     */
    public function paginator(PaginatorInterface $paginator)
    {
        // TODO: Implement paginator() method.
    }

    /**
     * Serialize the cursor.
     *
     * @param CursorInterface $cursor
     *
     * @return array
     */
    public function cursor(CursorInterface $cursor)
    {
        $count = (int)$cursor->getCount();

        $cursorCount = array_key_exists('count', $this->request['cursor']) ? $this->request['cursor']['count'] : CursorPagination::$cursorCount;

        if(!is_null($this->data->getCursor())) {

            if ($this->data->getCursor()->getCount() == ($cursorCount + 1)) {
                $count = (int)$cursor->getCount() - 1;
            }
        }

        $cursor = [
            'current' => $cursor->getCurrent(),
            'prev'    => $cursor->getPrev(),
            'next'    => $cursor->getNext(),
            'count'   => $count,
        ];

        return [
            'cursor' => $cursor,
        ];
    }

    /**
     * @return bool
     *
     * @author   Fathur Rohman <fathur@dragoncapital.center>
     */
    private function isMore()
    {
        return false;
    }

}
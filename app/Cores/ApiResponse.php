<?php
namespace App\Cores;
use File;
use Response;

trait ApiResponse {
    /**
	 * Renponse Variables
	 * @var array
	 */
	public $response = [
		'created' => [
			'data' => [
				'status' => true,
				'message' => 'Data has been created successfully.',
                'data' => []
			],
			'code' => 201
		],
		'updated' => [
			'data' => [
				'status' => true,
				'message' => 'Data updated successfully.',
                'data' => []
			],
			'code' => 200
		],
		'error' => [
			'data' => [
				'status' => false,
				'message' => 'Something Wrong.'
			],
			'code' => 400
		],
		'unauth' => [
			'data' => [
				'status' => false,
				'message' => 'Something Wrong.'
			],
			'code' => 401
		],
		'deleted' => [
			'data' => [
				'status' => false,
				'message' => 'Data deleted successfully.',
                'data' => []
			],
			'code' => 200
		],
		'pagination' => [
            'data' => [
                'data' => []
            ],
            'code' => 200
        ],
		'default' => [
			'data' => [
				'status' => true,
				'message' => 'OK',
                'data' => []
			],
			'code' => 200
		]
	];

	/**
     * Renponse Json
     * @param String $type
     * @param String $message
     * @param Array/Object $data
     * @param String/Int $code
     * @param String/Int $sort
     * @return Json
     */
	public function responseJson($type='default', $message='', $data = [], $code='', $sort = [])
	{
		switch ($type) {
			case 'created':
				$response = $this->response[$type];
				break;
			case 'updated':
				$response = $this->response[$type];
				break;
			case 'error':
				$response = $this->response[$type];
				break;
			case 'deleted':
				$response = $this->response[$type];
				break;
			case 'unauth':
				$response = $this->response[$type];
				break;
			case 'pagination':
                $response = $this->response[$type];
                $response['data']['data'] = $data;
                $response['data']['pagination'] = [
                    'total' => $data->total(),
                    'totalPage' => $data->lastPage(),
                    'page' => $data->currentPage(),
                    'sort' => $sort[1] ?? null,
                    'sortBy' => $sort[0] ?? null,
                    'items' => $data->count(),
                    'limit' => (int) app('request')->limit ?? $data->count(),
                ];
                break;
			default:
				$response = $this->response['default'];
				break;
		}

		if ($type != 'pagination') {
			if (!empty($message)) {
				$response['data']['message'] = $message;
			}
			if (!empty($data)){
				$response['data']['data'] = $data;
			} else {
				unset($response['data']['data']);
			}
		}
            
        if (!empty($code)) {
			$response['code'] = $code;
		}

		return response()
				->json($response['data'], $response['code']);
	}
}
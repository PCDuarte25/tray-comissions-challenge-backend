<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfigurationRequest;
use App\Repositories\ConfigurationRepository;
use App\Services\ApiResponse;
use Illuminate\Http\Response;

class ConfigurationController extends Controller
{
    /**
     * Creates a new instance of the ConfigurationController.
     */
    public function __construct(
        private ConfigurationRepository $configurationRepository
    ) {}

    public function updateConfiguration(ConfigurationRequest $request, string $id)
    {
        $data = $request->validated();

        $configuration = $this->configurationRepository->getConfigurationById($id);
        if (!$configuration) {
            return ApiResponse::error('Configuration not found', Response::HTTP_NOT_FOUND);
        }

        $updatedConfiguration = $this->configurationRepository->updateConfiguration($id, $data['value']);
        return ApiResponse::success(
            ['configuration' => $updatedConfiguration],
            Response::HTTP_OK,
            'Configuration updated successfully'
        );
    }
}

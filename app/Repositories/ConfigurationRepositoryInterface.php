<?php

namespace App\Repositories;

use App\Models\Configuration;
use Illuminate\Database\Eloquent\Collection;

interface ConfigurationRepositoryInterface
{
    /**
     * Get all configurations.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAllConfigurations(): Collection;

    /**
     * Get configuration by ID.
     *
     * @param int $id
     *
     * @return \App\Models\Configuration|null
     */
    public function getConfigurationById(int $id): ?Configuration;

    /**
     * Get configuration by key.
     *
     * @param string $key
     *
     * @return \App\Models\Configuration|null
     */
    public function getConfigurationByKey(string $key): ?Configuration;

    /**
     * Update configuration value by ID.
     *
     * @param int $id
     * @param string $value
     *
     * @return \App\Models\Configuration|null
     */
    public function updateConfiguration(int $id, string $value): ?Configuration;
}

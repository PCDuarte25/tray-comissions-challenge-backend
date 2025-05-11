<?php

namespace App\Repositories;

use App\Models\Configuration;
use Illuminate\Database\Eloquent\Collection;

interface ConfigurationRepositoryInterface
{
    /**
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAllConfigurations(): Collection;

    /**
     * @param int $id
     *
     * @return Configuration|null
     */
    public function getConfigurationById(int $id): ?Configuration;

    /**
     * @param string $key
     *
     * @return Configuration|null
     */
    public function getConfigurationByKey(string $key): ?Configuration;

    /**
     * @param int $id
     *
     * @param string $value
     *
     * @return Configuration|null
     */
    public function updateConfiguration(int $id, string $value): ?Configuration;
}

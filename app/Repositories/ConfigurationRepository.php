<?php

namespace App\Repositories;

use App\Models\Configuration;
use Illuminate\Database\Eloquent\Collection;

class ConfigurationRepository implements ConfigurationRepositoryInterface
{
    /**
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAllConfigurations(): Collection
    {
        return Configuration::all();
    }

    /**
     * @param int $id
     *
     * @return Configuration|null
     */
    public function getConfigurationById(int $id): ?Configuration
    {
        return Configuration::find($id);
    }

    /**
     * @param string $key
     *
     * @return Configuration|null
     */
    public function getConfigurationByKey(string $key): ?Configuration
    {
        return Configuration::where('key', $key)->first();
    }

    /**
     * @param int $id
     *
     * @param string $value
     *
     * @return Configuration|null
     */
    public function updateConfiguration(int $id, string $value): ?Configuration
    {
        $configuration = $this->getConfigurationById($id);
        if ($configuration) {
            $configuration->value = $value;
            $configuration->save();
        }
        return $configuration;
    }
}

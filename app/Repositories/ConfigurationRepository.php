<?php

namespace App\Repositories;

use App\Models\Configuration;
use Illuminate\Database\Eloquent\Collection;

class ConfigurationRepository implements ConfigurationRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getAllConfigurations(): Collection
    {
        return Configuration::all();
    }

    /**
     * @inheritDoc
     */
    public function getConfigurationById(int $id): ?Configuration
    {
        return Configuration::find($id);
    }

    /**
     * @inheritDoc
     */
    public function getConfigurationByKey(string $key): ?Configuration
    {
        return Configuration::where('key', $key)->first();
    }

    /**
     * @inheritDoc
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

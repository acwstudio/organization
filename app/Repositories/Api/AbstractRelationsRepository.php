<?php

declare(strict_types=1);

namespace App\Repositories\Api;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRelationsRepository
{
    private array $firstGroupRelations = ['HasOne', 'HasMany', 'morphOne', 'morphMany'];
    private array $secondGroupRelations = ['belongsTo', 'morphTo'];
    private array $thirdGroupRelations = ['belongsToMany', 'morphedToMany', 'morphedByMany'];

    /**
     * @param array $data
     * @return Model|Collection
     */
    abstract protected function indexRelations(array $data): Model|Collection;

    /**
     * @param array $data
     * @return void
     */
    abstract protected function storeRelations(array $data): void;

    /**
     * @param array $data
     * @return void
     */
    abstract protected function updateRelations(array $data): void;

    /**
     * @param array $data
     * @return void
     * @throws \ReflectionException
     */
    protected function handleStoreRelations(array $data): void
    {
        $model = data_get($data, 'model');
        $relationMethod = data_get($data, 'relation_method');

        $nameRelationClass = $this->shortNameClass(get_class($model->{$relationMethod}()));

        if (in_array($nameRelationClass, $this->firstGroupRelations)) {
            $this->storeFirstGroupRelations($data);
        }

        if (in_array($nameRelationClass, $this->secondGroupRelations)) {
            $this->storeSecondGroupRelations($data);
        }

        if (in_array($nameRelationClass, $this->thirdGroupRelations)) {
            $this->storeThirdGroupRelations($data);
        }
    }

    /**
     * @param array $data
     * @return void
     * @throws \ReflectionException
     */
    protected function handleUpdateRelations(array $data): void
    {
        $model = data_get($data, 'model');
        $relationMethod = data_get($data, 'relation_method');

        $nameRelationClass = $this->shortNameClass(get_class($model->{$relationMethod}()));

        if (in_array($nameRelationClass, $this->firstGroupRelations)) {
            $this->updateFirstGroupRelations($data);
        }

        if (in_array($nameRelationClass, $this->secondGroupRelations)) {
            $this->updateSecondGroupRelations($data);
        }

        if (in_array($nameRelationClass, $this->thirdGroupRelations)) {
            $this->updateThirdGroupRelations($data);
        }
    }

    /**
     * @param $data
     * @return void
     */
    private function storeFirstGroupRelations($data): void
    {
        $model = data_get($data, 'model');
        $relationMethod = data_get($data, 'relation_method');
        $relatedIds = data_get($data, 'relation_data.data.*.id');

        $nameRelatedModel = get_class($model->{$relationMethod}()->getRelated());

        $model->{$relationMethod}()->saveMany(app($nameRelatedModel)::find($relatedIds));
    }

    /**
     * @param $data
     * @return void
     */
    private function updateFirstGroupRelations($data): void
    {
        $model = data_get($data, 'model');
        $relationMethod = data_get($data, 'relation_method');
        $modelWithRelations = $model->{$relationMethod}();
        $relatedIds = data_get($data, 'relation_data.data.*.id');

        $nameRelatedModel = get_class($modelWithRelations->getRelated());
        $foreignKeyRelatedModel = $modelWithRelations->getForeignKeyName();

        foreach ($modelWithRelations->get() as $item) {
            $item->update([
                $foreignKeyRelatedModel => null
            ]);
        }

        $model->{$relationMethod}()->saveMany(app($nameRelatedModel)::find($relatedIds));
    }


    private function storeSecondGroupRelations($data): void
    {

    }

    private function storeThirdGroupRelations($data): void
    {

    }

    private function updateSecondGroupRelations($data): void
    {

    }

    private function updateThirdGroupRelations($data): void
    {

    }

    /**
     * @param string $className
     * @return string
     * @throws \ReflectionException
     */
    private function shortNameClass(string $className): string
    {
        return (new \ReflectionClass($className))->getShortName();
    }
}

<?php

declare(strict_types=1);

namespace App\Repositories\Api;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

abstract class AbstractRelationsRepository
{
    private array $relationToMany = ['HasMany', 'MorphMany','HasOne','MorphOne'];
    private array $relationToOne = ['BelongsTo', 'MorphTo'];
    private array $relationManyToMany = ['BelongsToMany', 'MorphedToMany', 'MorphedByMany'];

    private string $nameRelationClass;

    /**
     * @param array $data
     * @return HasMany|BelongsTo
     */
    abstract public function indexRelations(array $data): HasMany|BelongsTo;

    /**
     * @param array $data
     * @return void
     */
    abstract public function updateRelations(array $data): void;

    /**
     * @param array $data
     * @return void
     * @throws \ReflectionException
     */
    protected function handleUpdateRelations(array $data): void
    {
        $model = data_get($data, 'model');
        $relationMethod = data_get($data, 'relation_method');

        $this->nameRelationClass = $this->shortNameClass(get_class($model->{$relationMethod}()));

        if (in_array($this->nameRelationClass, $this->relationToMany)) {
            $this->updateRelationToMany($data);
        }

        if (in_array($this->nameRelationClass, $this->relationToOne)) {
            $this->updateRelationToOne($data);
        }

        if (in_array($this->nameRelationClass, $this->relationManyToMany)) {
            $this->updateRelationManyToMany($data);
        }
    }

    /**
     * @param $data
     * @return void
     */
    private function updateRelationToMany($data): void
    {
        $model = data_get($data, 'model');
        $relationMethod = data_get($data, 'relation_method');

        if ($this->nameRelationClass === 'HasMany') {
            $ids = data_get($data, 'relation_data.data.*.id');
        }

        if ($this->nameRelationClass === 'HasOne') {
            $ids = [data_get($data, 'relation_data.data.id')];
        }

        $foreignKey = $model->$relationMethod()->getForeignKeyName();
        $relatedModel = $model->$relationMethod()->getRelated();

        $relatedModel->newQuery()->where($foreignKey, $model->id)->update([
            $foreignKey => null,
        ]);

        $relatedModel->newQuery()->whereIn('id', $ids)->update([
            $foreignKey => $model->id,
        ]);
    }

    /**
     * @param $data
     * @return void
     */
    private function updateRelationToOne($data): void
    {
        $model = data_get($data, 'model');
        $relationMethod = data_get($data, 'relation_method');
        $id = data_get($data, 'relation_data.data.id');

        $relatedModel = $model->$relationMethod()->getRelated();

        $model->$relationMethod()->dissociate();

        if($id){
            $newModel = $relatedModel->newQuery()->findOrFail($id);
            $model->$relationMethod()->associate($newModel);
        }

        $model->save();
    }

    private function updateRelationManyToMany($data): void
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

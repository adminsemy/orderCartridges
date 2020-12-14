<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

/**
 * Class for brand and them cartridges
 */
class BrandCartridgesService
{        
    /**
     * @var object
     */
    private $model;    
    /**
     *
     * @var string
     */
    private $nameLink = '';    
    /**
     *
     * @var string
     */
    private $keyModel = '';    
    /**
     * @var array
     */
    private $delete = [];
    /**
     * @var array
     */
    private $insert = [];

    public function __construct(Model $model, string $nameLink, string $keyModel)
    {
        $this->model = $model;
        $this->nameLink = $nameLink;
        $this->keyModel = $keyModel;
    }

    public function handle(array $arryaRequest, string $keyRequest)
    {
        $arrayLink = $this->arrayLink();        
        $currentModelObjects = $this->id($arrayLink, $this->keyModel);
        
        $idRequestObjects = $this->id($arryaRequest);
        
        $this->remove($currentModelObjects, $idRequestObjects);
        $this->insert($currentModelObjects, $idRequestObjects, $keyRequest);
        return true;
    }
    
    /**
     * Return an array of id of cartridge from a request
     *
     * @param  array $objects
     * @return array
     */
    private function id(array $objects, string $key = 'id'): array
    {
        $id = array_map(function ($object) use ($key) {
            return (int) $object[$key];
        }, array_values($objects));

        $id = array_unique($id);

        return $id;
    }
    
    /**
     * Returns an array of cartridges for to delete
     *
     * @param  array $current
     * @param  array $removal
     * @return void
     */
    private function remove(array $current, array $removal): void
    {
        $delete = array_diff($current, $removal);

        if ([] === $delete) {
            return;
        }
        $this->delete($delete);
    }

    /**
     * Deleting current cartridges from reguest array and return the result
     *
     * @param  array $current
     * @param  array $insert
     * @return void
     */
    private function insert(array $current, array $insert, string $keyRequest): void
    {
        $insert = array_diff($insert, $current);

        if ([] === $insert) {
            return;
        }
        $this->add($insert, $keyRequest);
    }
    
    /**
     * Return array collection of objects by link
     *
     * @return array
     */
    private function arrayLink(): array
    {
        $nameLink = $this->nameLink;
        return $this->model->$nameLink->toArray();
    }

    private function add(array $newObjects, string $keyRequest)
    {
        $nameLink = $this->nameLink;
        $idModel = $this->model->id;
        $insert = [];
        foreach ($newObjects as $new) {
            $insert[] = [
                $this->keyModel => $new,
                $keyRequest => $idModel
            ];
        }
        $this->model->$nameLink()->createMany($insert);
    }

    private function delete(array $deleteObjects)
    {
        $nameLink = $this->nameLink;
        $this->model->$nameLink()->whereIn($this->keyModel, $deleteObjects)->delete();
    }

}

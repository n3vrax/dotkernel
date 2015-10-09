<?php

namespace DotBase\Mapper;

interface RestMapperInterface
{
    public function createEntity($data);
    
    public function deleteEntity($id);
    
    public function updateEntity($id, $data);
    
    public function fetchEntity($id);
    
    public function fetchEntityBy($field, $value);
    
    public function fetchAllEntities($params);
    
    public function fetchAllEntitiesPaginated($params);
}
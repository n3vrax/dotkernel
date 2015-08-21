<?php

namespace DotBase\Mapper;

interface CRUDMapperInterface
{
    public function create($data);
    
    public function delete($id);
    
    public function update($id, $data);
    
    public function fetch($id);
    
    public function fetchAll($params);
    
    public function fetchAllPaginated($params);
}
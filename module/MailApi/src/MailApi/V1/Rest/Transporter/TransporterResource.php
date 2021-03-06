<?php
namespace MailApi\V1\Rest\Transporter;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class TransporterResource extends AbstractResourceListener
{
    protected $mapper;
    
    public function __construct($mapper)
    {
        $this->mapper = $mapper;
    }
    
    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        try{
            $inputFilter = $this->getInputFilter();
            if($inputFilter)
            {
                $data = $inputFilter->getValues();
            }
            return $this->mapper->createEntity($data);
        }
        catch(\Exception $ex)
        {
            error_log($ex);
            return new ApiProblem(500, 'Api Server error');
        }
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        try{
            return $this->mapper->deleteEntity($id);
        }
        catch(\Exception $ex)
        {
            error_log($ex);
            return new ApiProblem(500, 'Api Server error');
        }
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        try{
            return $this->mapper->fetchEntity($id);
        }
        catch(\Exception $ex)
        {
            error_log($ex);
            return new ApiProblem(500, 'Api Server error');
        }
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = array())
    {
        try{
            return $this->mapper->fetchAllEntitiesPaginated($params);
        }
        catch(\Exception $ex)
        {
            error_log($ex);
            return new ApiProblem(500, 'Api Server error');
        }
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return $this->updateEntity($id, $data);
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        try{
            return $this->mapper->updateEntity($id, $data);
        }
        catch(\Exception $ex)
        {
            error_log($ex);
            return new ApiProblem(500, 'Api Server error');
        }
    }
}

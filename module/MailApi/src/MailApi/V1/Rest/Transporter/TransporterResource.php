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
            var_dump($data);exit;
            return $this->mapper->create($data);
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
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
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
            return $this->mapper->fetch($id);
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
            return $this->mapper->fetchAllPaginated($params);
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
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
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
            return $this->mapper->update($id, $data);
        }
        catch(\Exception $ex)
        {
            error_log($ex);
            return new ApiProblem(500, 'Api Server error');
        }
    }
}

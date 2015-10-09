<?php
namespace UserApi\V1\Rest\User;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use DotUser\Service\UserServiceInterface;
use Zend\Stdlib\Hydrator\Filter\FilterComposite;
use Zend\Stdlib\Hydrator\Filter\MethodMatchFilter;

class UserResource extends AbstractResourceListener
{
    protected $userService;
    
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }
    
    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        return new ApiProblem(405, 'The POST method has not been defined');
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
            if(is_numeric($id))
                $user =  $this->userService->fetchEntity($id);
            else 
                $user = $this->userService->findUserByUsername($id);
            
            //remove details filter from user if exists
            $user->removeHydratorFilter("details");
            
            return $user;
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
            $users = $this->userService->fetchAllEntitiesPaginated($params);
            foreach ($users as $user)
            {
                $user->addHydratorFilter("details", new MethodMatchFilter("getDetails"), FilterComposite::CONDITION_AND);
            }
            
            return $users;
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
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
}

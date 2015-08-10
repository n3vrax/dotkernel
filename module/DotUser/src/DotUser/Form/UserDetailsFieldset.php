<?php

namespace DotUser\Form;

use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\HydratorInterface;
use DotUser\Entity\UserDetailsInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Db\Sql\Select;

class UserDetailsFieldset extends Fieldset implements InputFilterProviderInterface
{
    protected $countryTable;
    
    protected $countryList = array();
    
    public function __construct(HydratorInterface $hydrator, UserDetailsInterface $entity, TableGateway $countryTable)
    {
        parent::__construct('details');
        $this->countryTable = $countryTable;
        $this->setHydrator($hydrator);
        $this->setObject($entity);
        
        $this->init();
    }
    
    public function init()
    {
        $this->add(array(
            'type' => 'hidden',
            'name' => 'userId',
        ));
        $this->add(array(
            'type' => 'text',
            'name' => 'firstName',
            'options' => array(
                'label' => 'First name',
            ),
        ));
        
        $this->add(array(
            'type' => 'text',
            'name' => 'lastName',
            'options' => array(
                'label' => 'Last name',
            ),
        ));
        
        $this->add(array(
            'type' => 'text',
            'name' => 'address',
            'options' => array(
                'label' => 'Address',
            ),
        ));
        
        $this->add(array(
            'type' => 'text',
            'name' => 'city',
            'options' => array(
                'label' => 'City',
            ),
        ));
        
        $this->add(array(
            'type' => 'text',
            'name' => 'region',
            'options' => array(
                'label' => 'Region',
            ),
        ));
        
        $this->add(array(
            'type' => 'select',
            'name' => 'country',
            'options' => array(
                'label' => 'Country',
                'empty_option' => 'Please choose your country',
                'value_options' => $this->getCountryList(),
            ),
        ));
        
        $this->add(array(
            'type' => 'text',
            'name' => 'postalCode',
            'options' => array(
                'label' => 'Postal Code',
            ),
        ));
        
        $this->add(array(
            'type' => 'text',
            'name' => 'phone',
            'options' => array(
                'label' => 'Phone number',
            ),
            'attributes' => array(
                'type' => 'tel',
                'pattern' => '^[\d-\/]+$',
            ),
        ));
    }
    
    public function getCountryList()
    {
        if(empty($this->countryList))
        {
            $this->countryList = array();
            $countries = $this->countryTable->select(function(Select $select){
                $select->columns(array('id', 'name'));
                $select->order('name ASC');
            });
    
                $countries = $countries->toArray();
                foreach ($countries as $country)
                {
                    $this->countryList[$country['name']] = $country['name'];
                }
        }
    
        return $this->countryList;
    }
    
    public function getInputFilterSpecification()
    {   
        return array(
            'firstName' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 0,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            'lastName' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 0,
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            'address' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            'city' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            'region' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            'country' => array(
                'required' => false,
            ),
            'postalCode' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'max' => 255,
                        ),
                    ),
                ),
            ),
            'phone' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'digits'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'max' => 255,
                        ),
                    ),
                    array(
                        'name' => 'regex',
                        'options' => array(
                            'pattern' => '/^[\d-\/]+$/',
                        ),
                    ),
                ),
            ),
        );
    }
}
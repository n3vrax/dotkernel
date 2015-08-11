<?php
namespace MailApi\V1\Rest\Transporter;

class TransporterResourceFactory
{
    public function __invoke($services)
    {
        $mapper = $services->get('DotMailTransporter\Mapper\TransporterMapperInterface');
        
        return new TransporterResource($mapper);
    }
}

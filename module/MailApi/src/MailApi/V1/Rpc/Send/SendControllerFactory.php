<?php
namespace MailApi\V1\Rpc\Send;

class SendControllerFactory
{
    public function __invoke($controllers)
    {
        return new SendController();
    }
}

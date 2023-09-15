<?php

namespace App\services\messaging;

use App\Exceptions\CustomException;
use Exception;

class SMS
{
    protected mixed $smsService;

    public function __construct()
    {
        $this->smsService = null;
    }


    /**
     * @param string $mobile
     * @param string $message
     * @return void
     * @throws CustomException
     */
    public function send(string $mobile, string $message): void
    {
        try {
            $this->smsService->send($mobile, $message);
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

}

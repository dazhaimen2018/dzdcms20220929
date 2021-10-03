<?php
/**
 * InvalidGatewayException.php
 *
 * Author: Guo
 *
 * Date:   2019-06-27 17:05
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Jonas\Translator\Exceptions;


use Throwable;

class InvalidGatewayException extends \Exception
{
    public $raw;
    public function __construct($message = "", $code = 1, $raw = [])
    {
        parent::__construct($message, $code);
        $this->raw = $raw;
    }
}
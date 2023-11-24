<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Response\Common;

use SunnyPHP\TTLock\Contract\Response\Common\SuccessResponseInterface;
use SunnyPHP\TTLock\Response\AbstractResponse;

/**
 * No data, no error, just success execution
 */
final class SuccessResponse extends AbstractResponse implements SuccessResponseInterface
{

}

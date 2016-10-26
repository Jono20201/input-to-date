<?php

namespace InputToDate;

use Carbon\Carbon;
use InvalidArgumentException;

class InputToDate
{
    /**
     * @var string
     */
    protected $input;

    /**
     * @var Carbon
     */
    protected $default;

    /**
     * @var string
     */
    protected $format;

    /**
     * @var bool
     */
    protected $throwException = false;

    /**
     * @var bool
     */
    protected $nullOnException = false;

    /**
     * @param null $input
     *
     * @return InputToDate
     */
    public static function create($input = null)
    {
        $instance = new self();

        if ($input) {
            $instance->setInput($input);
        }

        return $instance;
    }

    /**
     * @param $input string
     *
     * @return $this
     */
    public function setInput($input)
    {
        $this->input = $input;

        return $this;
    }

    /**
     * @param $default Carbon
     *
     * @return $this
     */
    public function setDefault(Carbon $default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * @param $format string
     *
     * @return $this
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @param bool $throwException
     *
     * @return $this
     */
    public function throwException($throwException = true)
    {
        $this->throwException = $throwException;

        return $this;
    }

    /**
     * @param bool $nullOnFailure
     *
     * @return $this
     */
    public function setReturnNullOnFailure($nullOnFailure = true)
    {
        $this->nullOnException = $nullOnFailure;

        return $this;
    }

    /**
     * @return bool
     */
    public function returnNullOnFailure()
    {
        return $this->nullOnException;
    }

    /**
     * @return string
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Checks if we will throw an exception upon failure of converting an input to Carbon.
     *
     * @return bool
     */
    public function willThrowException()
    {
        return $this->throwException || !$this->getDefault();
    }

    /**
     * @return Carbon
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string $input
     *
     * @throws \InvalidArgumentException
     *
     * @return Carbon|null
     */
    public function convert($input = null)
    {
        if ($input) {
            $this->setInput($input);
        }

        try {
            return Carbon::createFromFormat($this->getFormat(), $this->getInput());
        } catch (InvalidArgumentException $e) {
            if ($this->returnNullOnFailure()) {
                return null;
            }

            if ($this->willThrowException()) {
                throw $e;
            }

            return $this->getDefault(); // failed, so return default.
        }
    }
}

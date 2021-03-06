<?php
/**
 * Particle.
 *
 * @link      http://github.com/particle-php for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Particle (http://particle-php.com)
 * @license   https://github.com/particle-php/validator/blob/master/LICENSE New BSD License
 */
namespace Particle\Validator\Rule;

use Particle\Validator\Rule;

/**
 * This rule is for validating that the length of the value is within predefined boundaries.
 *
 * @package Particle\Validator\Rule
 */
class LengthBetween extends Rule
{
    /**
     * A constant that is used when the value is too long.
     */
    const TOO_LONG = 'LengthBetween::TOO_LONG';

    /**
     * A constant that is used when the value is too short.
     */
    const TOO_SHORT = 'LengthBetween::TOO_SHORT';

    /**
     * The message templates which can be returned by this validator.
     *
     * @var array
     */
    protected $messageTemplates = [
        self::TOO_LONG => 'The length of "{{ name }}" is too long, must be shorter than {{ max }} characters',
        self::TOO_SHORT => 'The length of "{{ name }}" is too short, must be longer than {{ min}} characters'
    ];

    /**
     * The upper boundary for the length of the value.
     *
     * @var int
     */
    protected $max;

    /**
     * The lower boundary for the length of the value.
     *
     * @var int
     */
    protected $min;

    /**
     * Whether or not the min and max length are inclusive.
     *
     * @var bool
     */
    protected $inclusive;

    /**
     * @param int $min
     * @param int $max
     * @param bool $inclusive
     */
    public function __construct($min, $max, $inclusive = true)
    {
        $this->min = $min;
        $this->max = $max;
        $this->inclusive = $inclusive;
    }

    /**
     * Validates that the length of the value is between min and max.
     *
     * @param mixed $value
     * @return bool
     */
    public function validate($value)
    {
        $length = strlen($value);

        if (($this->inclusive && $length > $this->max) || (!$this->inclusive && $length >= $this->max)) {
            return $this->error(self::TOO_LONG);
        }

        if (($this->inclusive && $length < $this->min) || (!$this->inclusive && $length <= $this->min)) {
            return $this->error(self::TOO_SHORT);
        }
        return true;
    }

    /**
     * Returns the parameters that may be used in a validation message.
     *
     * @return array
     */
    protected function getMessageParameters()
    {
        return array_merge(parent::getMessageParameters(), [
            'min' => $this->min,
            'max' => $this->max
        ]);
    }
}

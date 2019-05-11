<?php
/**
 * Created by PhpStorm.
 * User: aminejerbouh
 * Date: 30/04/2019
 * Time: 16:43
 */
declare(strict_types=1);

final class Identity
{
    private $firstName;
    private $lastName;

    /**
     * Identity constructor.
     * @param $firstName
     * @param $lastName
     */
    public function __construct(string $firstName, string $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function toString(): string
    {
        return $this->firstName.' '.$this->lastName;
    }
}
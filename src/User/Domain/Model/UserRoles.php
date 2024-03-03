<?php

namespace User\Domain\Model;

use Common\Application\Exception\ValidationException;
use Common\Domain\ValueObject\ArrayValueObject;
use User\Domain\Validation\Trait\RolesValidationTrait;

/**
 * Class UserRoles.
 *
 * This class represents a user's roles in the domain model. It extends the ArrayValueObject class and uses
 * the RolesValidationTrait for validation. The roles must be an array of strings.
 */
final class UserRoles extends ArrayValueObject
{
    use RolesValidationTrait;

    /**
     * UserRoles constructor.
     *
     * Validates that the roles are valid. If the validation fails, it throws a ValidationException.
     *
     * @param string[] $value The roles value
     *
     * @throws ValidationException
     */
    public function __construct(array $value)
    {
        $value[] = 'ROLE_USER';
        $violations = $this->validateRoles($value);
        if (!empty($violations)) {
            throw new ValidationException($violations);
        }
        parent::__construct($value);
    }
}

<?php

declare(strict_types=1);

namespace DKulyk\Nova;

use Laravel\Nova\Contracts\RelatableField;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ResourceRelationshipGuesser;

class HasManyWrapper extends HasMany
{
    use FieldWrapper;

    public function __construct(HasMany $field)
    {
        $this->config($field);
        $this->hasManyRelationship = $field->hasManyRelationship;
    }
}

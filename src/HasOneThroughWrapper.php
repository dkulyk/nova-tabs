<?php

declare(strict_types=1);

namespace DKulyk\Nova;

use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOneThrough;
use Laravel\Nova\Fields\ResourceRelationshipGuesser;
use Laravel\Nova\Nova;

class HasOneThroughWrapper extends HasOneThrough
{
    use FieldWrapper;

    public function __construct(HasOneThrough $field)
    {
        $this->config($field);

        $this->hasOneThroughRelationship = $field->hasOneThroughRelationship;
        $this->singularLabel = $field->singularLabel;
        $this->filledCallback = $field->fillCallback;
    }
}

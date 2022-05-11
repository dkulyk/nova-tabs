<?php

declare(strict_types=1);

namespace DKulyk\Nova;

use Laravel\Nova\Fields\HasOneThrough;
use Laravel\Nova\Fields\MorphToMany;

class MorphToManyWrapper extends MorphToMany
{
    use FieldWrapper;

    public function __construct(MorphToMany $field)
    {
        $this->config($field);

        $this->manyToManyRelationship = $field->manyToManyRelationship;
        $this->deleteCallback = $field->deleteCallback;

        $this->fieldsCallback =  $field->fieldsCallback;

        $this->actionsCallback =   $field->actionsCallback;

        $this->allowDuplicateRelations = $field->allowDuplicateRelations;
    }
}

<?php

declare(strict_types=1);

namespace DKulyk\Nova;

use Laravel\Nova\Contracts\RelatableField;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Field;

class BelongsToManyWrapper extends BelongsToMany
{
    use FieldWrapper;

    public function __construct(BelongsToMany $field)
    {
        $this->config($field);
        $this->manyToManyRelationship = $field->manyToManyRelationship;
        $this->deleteCallback = $field->deleteCallback;
        $this->fieldsCallback = $field->fieldsCallback;
        $this->actionsCallback = $field->fieldsCallback;
        $this->allowDuplicateRelations = $field->allowDuplicateRelations;
        $this->creationRulesCallback = $field->creationRulesCallback;
    }
}

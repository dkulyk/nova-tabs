<?php

declare(strict_types=1);

namespace DKulyk\Nova;

use Laravel\Nova\Contracts\ListableField;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * @template T
 * @mixin T
 */
trait FieldWrapper
{
    protected Field|ListableField $field;

    /**
     * @param  T  $field
     * @return void
     */
    protected function config(Field|ListableField $field): void
    {
        $this->field = $field;

        $this->field = $field;

        $this->name = $field->name;
        $this->attribute = $field->attribute;
        $this->resolveCallback = $field->resolveCallback;

        $this->resourceClass = $field->resourceClass;
        $this->resourceName = $field->resourceName;
    }

    public function jsonSerialize(): array
    {
        return $this->field->jsonSerialize();
    }

    public function relationshipName(): string
    {
        return $this->field->relationshipName();
    }

    public function relationshipType(): string
    {
        return $this->field->relationshipType();
    }

    public function isShownOnCreation(NovaRequest $request): bool
    {
        return $this->field->isShownOnCreation($request);
    }

    public function isShownOnDetail(NovaRequest $request, $resource): bool
    {
        return $this->field->isShownOnDetail($request, $resource);
    }

    public function isShownOnIndex(NovaRequest $request, $resource): bool
    {
        return false;
    }

    public function isShownOnPreview(NovaRequest $request, $resource): bool
    {
        return $this->field->isShownOnPreview($request, $resource);
    }

    public function isShownOnUpdate(NovaRequest $request, $resource): bool
    {
        return $this->field->isShownOnUpdate($request, $resource);
    }

    public function asPanel()
    {
        return $this;
    }

    public function getManyToManyCreationRules(NovaRequest $request)
    {
        return $this->field->getManyToManyCreationRules($request);
    }
}

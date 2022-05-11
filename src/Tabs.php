<?php

namespace DKulyk\Nova;

use Illuminate\Http\Resources\ConditionallyLoadsAttributes;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Http\Resources\PotentiallyMissing;
use Laravel\Nova\Contracts\BehavesAsPanel;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\FieldCollection;
use Laravel\Nova\Fields\FieldFilterable;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOneThrough;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\ResolvesFields;
use RuntimeException;
use Laravel\Nova\Panel;
use Illuminate\Http\Resources\MergeValue;
use Laravel\Nova\Contracts\ListableField;

class Tabs extends Panel
{
    public $component = 'dkulyk-nova-tabs';

    /**
     * Prepare the given fields.
     *
     * @param  (\Closure():array|iterable)|array|iterable  $fields
     * @return array
     */
    protected function prepareFields($fields): array
    {
        return collect(is_callable($fields) ? $fields() : $fields)->map(function (Panel|ListableField $panel) {
            if ($panel instanceof BehavesAsPanel) {
                if ($panel instanceof HasMany) {
                    $field = new HasManyWrapper($panel);
                }

                if ($panel instanceof BelongsToMany) {
                    $field = new BelongsToManyWrapper($panel);
                }

                if ($panel instanceof HasOneThrough) {
                    $field = new HasOneThroughWrapper($panel);
                }

                if($panel instanceof MorphToMany) {
                    $field = new MorphToManyWrapper($panel);
                }

                $field->assignedPanel = $this;
                $field->panel = $this->name;
                $field->component = 'relationship-panel';
                $panel->withMeta([
                    'tab' => $panel->asPanel()->name,
                ]);

                return [$field];
            }

            return collect($panel->data)->map(function ($field) use ($panel) {
                $field->assignedPanel = $this;
                $field->panel = $this->name;
                $field->withMeta([
                    'tab' => $panel->name,
                ]);

                return $field;
            });
        })->flatten(1)->all();
    }
}

<?php

namespace DKulyk\Nova;

use RuntimeException;
use Laravel\Nova\Panel;
use Laravel\Nova\Contracts\ListableField;

class Tabs extends Panel
{
    public $defaultSearch = false;

    /**
     * Prepare the given fields.
     *
     * @param  \Closure|array $fields
     * @return array
     */
    protected function prepareFields($fields)
    {
        collect(is_callable($fields) ? $fields() : $fields)->each(function ($fields, $key) {
            if (is_string($key) && is_array($fields)) {
                $fields = new Panel($key, $fields);
            }

            $this->addTab($fields);
        });

        return $this->data;
    }

    /**
     * @param  Panel|\Laravel\Nova\Contracts\ListableField $panel
     * @return \DKulyk\Nova\Tabs
     */
    public function addTab($panel): self
    {
        if ($panel instanceof ListableField) {
            $panel->panel = $this->name;

            $panel->withMeta([
                'tab' => $panel->name,
                'listable' => false,
                'listableTab' => true
            ]);
            $this->data[] = $panel;
        } elseif ($panel instanceof Panel) {
            foreach ($panel->data as $field) {
                if ($field instanceof ListableField) {
                    throw new RuntimeException('Listable field does not support in Panel tab.');
                }

                $field->panel = $this->name;

                $field->withMeta([
                    'tab' => $panel->name,
                ]);

                $this->data[] = $field;
            }
        } else {
            throw new RuntimeException('Only listable fields or Panel allowed.');
        }

        return $this;
    }

    /**
     * @param  bool $value
     * @return \DKulyk\Nova\Tabs
     */
    public function defaultSearch($value = true)
    {
        $this->defaultSearch = $value;

        return $this;
    }

    /**
     * Prepare the panel for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'component' => 'dkulyk-tabs',
            'defaultSearch' => $this->defaultSearch,
        ]);
    }
}

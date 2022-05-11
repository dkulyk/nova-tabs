<template>
  <div class="tab-group" v-if="tabs.length > 1">
    <Heading :level="1" :class="panel.helpText ? 'mb-2' : 'mb-3'">{{
        panel.name
      }}</Heading>

    <p
      v-if="panel.helpText"
      class="text-gray-500 text-sm font-semibold italic mb-3"
      v-html="panel.helpText"
    />

    <Card class="tab-card">
      <div id="tabs">
        <div class="block">
          <nav
            aria-label="Tabs"
            class="tab-menu"
          >
            <a
              v-for="(tab, key) in tabs"
              :key="key"
              :dusk="tab.slug + '-tab'"
              :class="getIsTabCurrent(tab) ? 'active text-primary-500 tabs-font-bold' : 'tabs-text-gray-600 hover:tabs-text-gray-800 dark:tabs-text-gray-400 hover:dark:tabs-text-gray-200'"
              class="tab-item"
              @click.prevent="handleTabClick(tab)"
            >
              <span class="capitalize">{{ tab.name }}</span>
              <span
                v-if="getIsTabCurrent(tab)"
                aria-hidden="true"
                class="bg-primary-500 tabs-absolute tabs-inset-x-0 tabs-bottom-0 tabs-h-0.5"
              ></span>
              <span
                v-else
                aria-hidden="true"
                class="tabs-bg-transparent tabs-absolute tabs-inset-x-0 tabs-bottom-0 tabs-h-0.5"
              ></span>
            </a>
          </nav>
        </div>
      </div>

      <FormPanel
        v-for="(tab, index) in tabs"
        :key="'related-tabs-fields' + index"
        :class="['tab']"
        :label="tab.name"
        v-show="getIsTabCurrent(tab)"

        :panel="tab"
        :name="tab.name"
        :resource-id="resourceId"
        :resource-name="resourceName"
        :fields="tab.fields"
        :related-resource-name="relatedResourceName"
        :related-resource-id="relatedResourceId"
        :mode="mode"
        :via-resource="viaResource"
        :via-resource-id="viaResourceId"
        :via-relationship="viaRelationship"
        :shown-via-new-relation-modal="shownViaNewRelationModal"
        :form-unique-id="formUniqueId"
        :validation-errors="validationErrors"
        @field-changed="$emit('field-changed')"
        @update-last-retrieved-at-timestamp="$emit('update-last-retrieved-at-timestamp')"
        @file-upload-started="$emit('file-upload-started')"
        @file-upload-finished="$emit('file-upload-finished')"
      />
    </Card>

  </div>
  <FormPanel v-else
             :panel="panel"
             :name="name"
             :errors="validationErrors"
             :resource-id="resourceId"
             :resource-name="resourceName"
             :fields="panel.fields"
             :related-resource-name="relatedResourceName"
             :related-resource-id="relatedResourceId"
             :mode="mode"
             :via-resource="viaResource"
             :via-resource-id="viaResourceId"
             :via-relationship="viaRelationship"
             :shown-via-new-relation-modal="shownViaNewRelationModal"
             :form-unique-id="formUniqueId"
             :validation-errors="validationErrors"
             @field-changed="$emit('field-changed')"
             @update-last-retrieved-at-timestamp="$emit('update-last-retrieved-at-timestamp')"
             @file-upload-started="$emit('file-upload-started')"
             @file-upload-finished="$emit('file-upload-finished')"
  />
</template>

<script>

import TabsMixin from "./TabsMixin";

export default {
  mixins:[TabsMixin],
  emits: [
    'field-changed',
    'update-last-retrieved-at-timestamp',
    'file-upload-started',
    'file-upload-finished',
  ],

  props: {
    shownViaNewRelationModal: {
      type: Boolean,
      default: false,
    },

    panel: {
      type: Object,
      required: true,
    },

    name: {
      default: 'Panel',
    },

    mode: {
      type: String,
      default: 'form',
    },

    fields: {
      type: Array,
      default: [],
    },

    formUniqueId: {
      type: String,
    },

    validationErrors: {
      type: Object,
      required: true,
    },

    resourceName: {
      type: String,
      required: true,
    },

    resourceId: {
      type: [Number, String],
    },

    relatedResourceName: {
      type: String,
    },

    relatedResourceId: {
      type: [Number, String],
    },

    viaResource: {
      type: String,
    },

    viaResourceId: {
      type: [Number, String],
    },

    viaRelationship: {
      type: String,
    },
  },

  watch: {
    validationErrors(value) {
      const fields = Object.keys(value.errors);
      console.log(fields);
      if (fields.length) {
        this.tabs.some((tab) => {
          console.log(tab.name,tab.fields.some(field => fields.includes(field)));
          if (tab.fields.some(field => fields.includes(field.attribute))) {
            this.handleTabClick(tab);
            return true;
          }
        });
      }
    },
  },
};
</script>

<template>
  <div class="tab-group">
    <slot>
      <Heading :level="1" v-text="panel.name" v-if="panel.showTitle"/>
      <p
        v-if="panel.helpText"
        :class="panel.helpText ? 'tabs-mt-2' : 'tabs-mt-3'"
        class="tabs-text-gray-500 tabs-text-sm tabs-font-semibold tabs-italic"
        v-html="panel.helpText"
      ></p>
    </slot>

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

      <div
        v-for="(tab, index) in tabs"
        :key="'related-tabs-fields' + index"
        :class="['tab']"
        :label="tab.name"
        v-show="getIsTabCurrent(tab)"
      >
        <KeepAlive>
          <div class="mt-1 px-6">
            <component
              :key="index"
              v-for="(field, index) in tab.fields"
              :index="index"
              :is="resolveComponentName(field)"
              :resource-name="resourceName"
              :resource-id="resourceId"
              :resource="resource"
              :field="field"
              @actionExecuted="actionExecuted"
            />
          </div>
        </KeepAlive>
      </div>
    </Card>
  </div>
</template>

<script>
import BehavesAsPanel from 'BehavesAsPanel';
import TabsMixin from "./TabsMixin";

export default {
  mixins: [BehavesAsPanel, TabsMixin],
  methods: {
    resolveComponentName(field) {
      return field.prefixComponent
        ? 'detail-' + field.component
        : field.component;
    },
  },
};
</script>

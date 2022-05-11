export default {
  data() {
    return {
      activeTab: 0,
    };
  },
  methods: {
    handleTabClick(tab) {
      this.activeTab = this.tabs.indexOf(tab);
    },

    getIsTabCurrent(tab) {
      return this.activeTab === this.tabs.indexOf(tab);
    },
  },
  computed: {
    tabs() {
      let tabs = {};

      this.panel.fields.forEach(field => {
        if (!tabs.hasOwnProperty(field.tab)) {
          tabs[field.tab] = {
            name: field.tab,
            init: false,
            listable: field.listableTab,
            fields: [],
          };
        }

        tabs[field.tab].fields.push(field);
      });
      return Object.values(tabs);
    },
  },
}

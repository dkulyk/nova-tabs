import DetailTabs from './components/DetailTabs.vue'
import FormTabs from './components/FormTabs.vue'

Nova.booting((app, store) => {
  app.component('detail-dkulyk-nova-tabs', DetailTabs)
  app.component('form-dkulyk-nova-tabs', FormTabs)
})

import { defineStore } from 'pinia'
import { router } from '@inertiajs/vue3'

export const useMenuTabStore = defineStore('menuTabs', {
  state: () => ({
    tabs: [],
    activeTab: null,
  }),
  actions: {
    closeAllTabs() {
      this.tabs = []
      this.activeTab = null
    },
    openTab(item) {
      const exists = this.tabs.find(tab => tab.url === item.url)
      if (!exists) {
        this.tabs.push({
          key: item.key,
          label: item.label,
          url: item.url,
          icon: item.icon,
        })
      }
      this.activeTab = item.url
    },
    closeTab(url) {
      const index = this.tabs.findIndex(tab => tab.url === url)
      if (index !== -1) {
        this.tabs.splice(index, 1)
        if (this.activeTab === url) {
          const fallback = this.tabs[index - 1] || this.tabs[0]
          this.activeTab = fallback?.url ?? null
          if (fallback?.url) {
            router.visit(fallback.url)
          }
        }
      }
    },
    setActive(url) {
      this.activeTab = url
    },
  },persist: true,
})

import { defineStore } from 'pinia'

export const useMenuTabStore = defineStore('menuTabs', {
  state: () => ({
    tabs: [],
    activeTab: null,
  }),
  actions: {
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
            Inertia.visit(fallback.url)
          }
        }
      }
    },
    setActive(url) {
      this.activeTab = url
    },
  }
})

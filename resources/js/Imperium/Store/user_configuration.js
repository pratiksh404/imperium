import { defineStore } from 'pinia';
export const useUserConfigurationStore = defineStore('userConfiguration', {
    state: () => ({
        userConfiguration: {
            isDarkMode: false,
            sidebarCollapsed: false,
        },
    }),
    actions: {
        setConfig(key, value) {
          this.configs[key] = value
        },
        toggleConfig(key) {
          this.configs[key] = !this.configs[key]
        },
      },
      persist: true,
});
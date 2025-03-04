import { onClickOutside } from '@vueuse/core';

export default {
  mounted(el, binding) {
    if (typeof binding.value !== 'function') {
      console.warn('v-click-outside requires a function as the value');
      return;
    }
    
    // Use VueUse's onClickOutside to detect outside clicks
    el.__clickOutsideHandler__ = (event) => {
      binding.value(event);
    };

    onClickOutside(el, el.__clickOutsideHandler__);
  },

  beforeUnmount(el) {
    // Cleanup the event listener
    if (el.__clickOutsideHandler__) {
      el.__clickOutsideHandler__ = null;
    }
  },
};

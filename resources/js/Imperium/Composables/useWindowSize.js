import { ref, computed, onMounted, onUnmounted } from 'vue';

export function useWindowSize() {
    const windowSize = ref({
        width: window.innerWidth,
        height: window.innerHeight,
    });

    const breakpoints = {
        sm: 640, // Small screen
        md: 768, // Medium screen
        lg: 1024, // Large screen
        xl: 1280, // Extra large screen
        '2xl': 1536, // 2x Extra large screen
    };

    const currentBreakpoint = computed(() => {
        const { width } = windowSize.value;
        if (width < breakpoints.sm) return 'xs';
        if (width < breakpoints.md) return 'sm';
        if (width < breakpoints.lg) return 'md';
        if (width < breakpoints.xl) return 'lg';
        if (width < breakpoints['2xl']) return 'xl';
        return '2xl';
    });

    const updateWindowSize = () => {
        windowSize.value.width = window.innerWidth;
        windowSize.value.height = window.innerHeight;
    };

    onMounted(() => {
        window.addEventListener('resize', updateWindowSize);
    });

    onUnmounted(() => {
        window.removeEventListener('resize', updateWindowSize);
    });

    return {
        windowSize,
        currentBreakpoint,
    };
}

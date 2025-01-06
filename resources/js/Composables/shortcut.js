import { ref, onMounted, onUnmounted } from 'vue'

// Various keyboard shortcut handlers
export function useShortcut(shortcut, callback) {
    const handleKeydown = (event) => {
        const isMac = navigator.platform.toUpperCase().indexOf("MAC") >= 0;

        const isCmdOrCtrl = isMac
            ? event.metaKey // Command key for Mac
            : event.ctrlKey; // Ctrl key for Windows/Linux

        if (isCmdOrCtrl && event.key.toLowerCase() === shortcut.toLowerCase()) {
            event.preventDefault();
            callback();
        }
    };

    onMounted(() => {
        window.addEventListener("keydown", handleKeydown);
    });

    onUnmounted(() => {
        window.removeEventListener("keydown", handleKeydown);
    });
}
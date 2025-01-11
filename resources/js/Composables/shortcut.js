import { onMounted, onUnmounted } from 'vue';

// Keyboard shortcut handler enforcing Meta/Ctrl automatically based on platform
export function useShortcut(shortcut, callback) {
    const handleKeydown = (event) => {
        const isMac = navigator.platform.toUpperCase().indexOf("MAC") >= 0;

        // Normalize the key for comparison
        const normalizeKey = (key) => key.toLowerCase().trim();

        // Ensure the platform-specific modifier is pressed
        const isCmdOrCtrlPressed = isMac ? event.metaKey : event.ctrlKey;
        if (!isCmdOrCtrlPressed) return;

        // Split and normalize the keys in the shortcut (e.g., "shift+s")
        const keys = shortcut.split("+").map(normalizeKey);

        // Check if all keys in the shortcut are matched
        const keySet = new Set(keys);

        console.log(event.key);
        // Check if all keys in the shortcut are pressed
        const allKeysPressed = keys.every((key) => {
            if (key === "meta" || key === "ctrl") return isCmdOrCtrlPressed;
            if (key === "shift") return event.shiftKey;
            if (key === "alt") return event.altKey;
            return normalizeKey(event.key) === key;
        });

        if (allKeysPressed) {
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

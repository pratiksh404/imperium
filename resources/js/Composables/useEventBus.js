import mitt from "mitt";
const eventBus = mitt();

export function useEventBus() {
    return {
        on: eventBus.on,
        off: eventBus.off,
        emit: eventBus.emit,
    };
}

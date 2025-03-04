

import { Link } from '@inertiajs/vue3';
export function useLinkComponentResolver(type) {
    switch (type) {
        case 'route':
            return Link;
        case 'url':
            return 'a';
        default:
            return 'a';
    }
}

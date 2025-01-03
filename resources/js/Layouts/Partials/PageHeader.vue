<template>
    <!-- Breadcrumbs Nav -->
    <nav v-if="breadcrumbs.length" class="dynamic-bg border-b dynamic-border">
        <Container :fluid="true">
            <div class="flex items-center justify-between flex-wrap">
                <div>
                    <Breadcrumb :pt="{
                        root: {
                            class: 'py-4 bg-transparent',
                        },
                    }" :home="{
                        icon: 'pi pi-home',
                        route: route('welcome'),
                    }" :model="breadcrumbs">
                        <template #item="{ item, props }">
                            <Link v-if="item.route" :href="item.route" class="p-breadcrumb-item-link" custom>
                            <span v-show="item.icon" :class="item.icon" class="p-breadcrumb-item-icon" />
                            <span class="p-breadcrumb-item-label">{{ item.label }}</span>
                            </Link>
                            <a v-else :href="item.url" :target="item.target" v-bind="props.action">
                                <span v-show="item.icon" :class="item.icon" class="p-breadcrumb-item-icon" />
                                <span class="p-breadcrumb-item-label">{{ item.label }}</span>
                            </a>
                        </template>
                        <template #separator> / </template>
                    </Breadcrumb>
                </div>
                <div>
                    <div v-if="$slots.headerEnd" class="py-3">
                        <slot name="headerEnd" />
                    </div>
                </div>
            </div>
        </Container>
    </nav>

    <!-- Page Title -->
    <section v-if="pageTitle">
        <Container :fluid="true" class="my-4 md:mt-8 md:mb-6">
            <div class="flex items-end justify-between flex-wrap">
                <div>
                    <h1 class="font-bold text-2xl md:text-3xl leading-tight">
                        {{ pageTitle }}
                    </h1>
                </div>
                <div>
                    <div v-if="$slots.titleEnd">
                        <slot name="titleEnd" />
                    </div>
                </div>
            </div>
        </Container>
    </section>

</template>
<script setup>
const props = defineProps({
    pageTitle: {
        type: String,
        required: false,
    },
    breadcrumbs: {
        type: Array,
        required: false,
        default: () => [],
    },
});
</script>

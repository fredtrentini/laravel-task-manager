<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { projects as projectsRoute } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const props = defineProps<{
    projects: Array<{
        id: number;
        title: string;
        description?: string | null;
        start_date?: string | null;
        end_date?: string | null;
        file?: string | null;
    }>;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Projetos',
        href: projectsRoute().url,
    },
];
</script>

<template>
    <Head title="Projetos" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="space-y-4">
                <div v-if="props.projects && props.projects.length > 0" class="grid gap-4">
                    <div v-for="project in props.projects" :key="project.id" class="rounded border p-4">
                        <div class="flex items-start justify-between">
                            <h3 class="text-lg font-semibold">{{ project.title }}</h3>
                            <div class="text-sm text-gray-500">
                                <span v-if="project.start_date">{{ project.start_date }}</span>
                                <span v-if="project.start_date && project.end_date"> — </span>
                                <span v-if="project.end_date">{{ project.end_date }}</span>
                            </div>
                        </div>
                        <p class="mt-2 text-sm text-gray-700" v-if="project.description">{{ project.description }}</p>
                        <div class="mt-3">
                            <a v-if="project.file" :href="`/storage/${project.file}`" target="_blank" rel="noopener noreferrer" class="text-sm text-indigo-600 hover:underline">Download / Visualizar arquivo</a>
                            <span v-else class="text-sm text-gray-500">Nenhum arquivo anexado</span>
                        </div>
                    </div>
                </div>

                <div v-else class="rounded border p-4 text-gray-600">Sem projetos</div>
            </div>
        </div>
    </AppLayout>
</template>

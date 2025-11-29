<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import projectsRoutes from '@/routes/projects';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { ref } from 'vue';
import ProjectsCreate from './ProjectsCreate.vue';

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

const isCreating = ref(false);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Projetos',
        href: projectsRoutes.index().url,
    },
];
</script>

<template>
    <Head title="Projetos" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="mb-4">
                <div v-if="!isCreating">
                    <Button type="button" @click="isCreating = true">Adicionar projeto</Button>
                </div>

                <div v-else>
                    <ProjectsCreate :form="projectsRoutes.store.form()" @go-back="isCreating = false" />
                </div>
            </div>
            
            <div class="space-y-4" v-if="!isCreating">
                <div v-if="props.projects.length > 0" class="grid gap-4">
                    <div v-for="project in props.projects" :key="project.id" class="rounded border p-4">
                        <div class="flex items-start justify-between">
                            <h3 class="text-lg font-semibold">{{ project.title }}</h3>
                            <div class="text-sm text-gray-500">
                                <span>{{ project.start_date }} — {{ project.end_date }}</span>
                            </div>
                        </div>

                        <p class="mt-2 text-sm text-gray-700">{{ project.description }}</p>
                        
                        <div class="mt-3">
                            <a v-if="project.file" :href="`/storage/${project.file}`" target="_blank" rel="noopener noreferrer" class="text-sm text-indigo-600 hover:underline">
                                Visualizar arquivo
                            </a>
                            <span v-else class="text-sm text-gray-500">Nenhum arquivo anexado</span>
                        </div>
                    </div>
                </div>

                <div v-else class="rounded border p-4 text-gray-600">Sem projetos</div>
            </div>
        </div>
    </AppLayout>
</template>

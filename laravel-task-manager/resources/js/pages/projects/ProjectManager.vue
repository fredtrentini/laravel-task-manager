<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import projectsRoutes from '@/routes/projects';
import type { Project, BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { ref } from 'vue';
import ProjectForm from './ProjectForm.vue';
import ProjectItem from './ProjectItem.vue';

const props = defineProps<{
    projects: Array<Project>;
}>();

const isCreating = ref(false);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Projetos',
        href: projectsRoutes.index().url,
    },
];

const { projects } = props;
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

                <ProjectForm v-else :form="projectsRoutes.store.form()" @go-back="isCreating = false" />
            </div>
            
            <div class="space-y-4" v-if="!isCreating">
                <div v-if="projects.length > 0" class="grid gap-4">
                    <ProjectItem v-for="project in projects" :key="project.id" :project="project" />
                </div>

                <div v-else class="rounded border p-4 text-gray-600">Sem projetos</div>
            </div>
        </div>
    </AppLayout>
</template>

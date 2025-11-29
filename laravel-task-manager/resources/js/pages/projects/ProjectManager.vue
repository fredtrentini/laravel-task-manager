<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import projectsRoutes from '@/routes/projects';
import type { Project, BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { computed, ref, watch } from 'vue';
import ProjectForm from './ProjectForm.vue';
import ProjectItem from './ProjectItem.vue';

const props = defineProps<{
    projects: Array<Project>;
}>();

const formState = ref<"creating" | "editing" | null>(null);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: "Projetos",
        href: projectsRoutes.index().url,
    },
];

const localProjects = ref<Project[]>(props.projects ?? []);

const projectIdToEdit = ref<number>(-1);

const projectToEdit = computed(() => {
    return localProjects.value.find(
        (project) => project.id === projectIdToEdit.value
    );
});

watch(
    () => props.projects,
    (updatedLocalProjects) => {
        localProjects.value = updatedLocalProjects ?? [];
    },
);

function handleProjectEdit(projectId: number) {
    formState.value = "editing";
    projectIdToEdit.value = projectId;
}

function deleteProject(targetProject: Project) {
    router.delete(`/projects/${targetProject.id}`, {
        onSuccess: () => {
            localProjects.value = localProjects.value.filter(
                (project) => project.id !== targetProject.id
            );
        },
    });
}

function resetFormState() {
    formState.value = null;
    projectIdToEdit.value = -1;
}
</script>

<template>
    <Head title="Projetos" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div v-if="formState == null" class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="mb-1">
                <div>
                    <Button type="button" @click="formState = 'creating'">Adicionar projeto</Button>
                </div>
            </div>
            
            <div class="space-y-4">
                <div v-if="localProjects.length > 0" class="grid gap-4">
                    <ProjectItem
                    v-for="project in localProjects"
                    :key="project.id"
                    :project="project"
                    @project-edit="handleProjectEdit"
                    @project-deleted="deleteProject(project)" />
                </div>

                <div v-else class="rounded border p-4 text-gray-600">Sem projetos</div>
            </div>
        </div>

        <ProjectForm v-else-if="formState == 'creating'" :form="projectsRoutes.store.form()" @go-back="resetFormState" />
        <ProjectForm v-else :form="projectsRoutes.update.form({ id: projectIdToEdit })" :project="projectToEdit" @go-back="resetFormState" />
    </AppLayout>
</template>

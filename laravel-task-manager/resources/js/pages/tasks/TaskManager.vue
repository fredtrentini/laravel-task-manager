<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import projectsRoutes from '@/routes/projects';
import tasksRoutes from '@/routes/tasks';
import type { Task, Project, BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { computed, ref, watch } from 'vue';
import TaskForm from './TaskForm.vue';
import TaskItem from './TaskItem.vue';

const props = defineProps<{
    project: Project;
    tasks: Array<Task>;
}>();

const project = props.project;
const localTasks = ref<Task[]>(props.tasks ?? []);

const formState = ref<"creating" | "editing" | null>(null);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: "Projetos",
        href: projectsRoutes.index().url,
    },
    {
        title: "Tarefas",
        href: tasksRoutes.index({ id: project.id }).url,
    },
];

const taskIdToEdit = ref<number>(-1);

const taskToEdit = computed(() => {
    return localTasks.value.find(
        (task) => task.id === taskIdToEdit.value
    );
});

watch(
    () => props.tasks,
    (updatedLocalTasks) => {
        localTasks.value = updatedLocalTasks ?? [];
    },
);

function handleTaskEdit(projectId: number, taskId: number) {
    formState.value = "editing";
    taskIdToEdit.value = taskId;
}

function deleteTask(projectId: number, targetTask: Task) {
    router.delete(`/projects/${projectId}/tasks/${targetTask.id}`, {
        onSuccess: () => {
            localTasks.value = localTasks.value.filter(
                (task) => task.id !== targetTask.id
            );
        },
    });
}

function resetFormState() {
    formState.value = null;
    taskIdToEdit.value = -1;
}
</script>

<template>
    <Head title="Tarefas" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div v-if="formState == null" class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="mb-1">
                <div>
                    <Button type="button" @click="formState = 'creating'">Adicionar tarefa</Button>
                </div>
            </div>
            
            <div class="space-y-4">
                <div v-if="localTasks.length > 0" class="grid gap-4">
                    <TaskItem
                    v-for="task in localTasks"
                    :key="task.id"
                    :project="project"
                    :task="task"
                    @task-edit="handleTaskEdit"
                    @task-deleted="deleteTask(project.id, task)" />
                </div>

                <div v-else class="rounded border p-4 text-gray-600">Sem tarefas</div>
            </div>
        </div>

        <TaskForm v-else-if="formState == 'creating'"
            :form="tasksRoutes.store.form({ project: project.id })"
            :project="project"
            @go-back="resetFormState"
        />
        <TaskForm v-else
            :form="tasksRoutes.update.form({ project: project.id, task: taskIdToEdit })"
            :project="project"
            :task="taskToEdit"
            @go-back="resetFormState"
        />
    </AppLayout>
</template>

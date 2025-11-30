<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { Task, type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import TaskStatus from '@/enums/TaskStatus';
import dayjs from 'dayjs';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

const props = defineProps<{
    tasks: Array<Task>;
}>();

const { tasks } = props;

const pendingTasks = computed(() => {
    return tasks.filter((task) => {
        return task.status < TaskStatus.COMPLETED && dayjs(task.due_date).isAfter(dayjs());
    });
});

const dueTasks = computed(() => {
    return tasks.filter((task) => {
        return task.status < TaskStatus.COMPLETED && dayjs(task.due_date).isBefore(dayjs());
    });
});
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="grid auto-rows-min gap-4 md:grid-cols-2 justify-between">
                <div>
                    <h2 class="mb-2 text-lg font-medium text-center">Tarefas pendentes</h2>
                    <div class="grid gap-3">
                        <div
                            v-for="task in pendingTasks"
                            :key="task.id"
                            class="rounded border p-4"
                        >
                            <h3 class="font-medium">{{ task.title }}</h3>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="mb-2 text-lg font-medium text-center">Tarefas atrasadas</h2>
                    <div class="grid gap-3">
                        <div
                            v-for="task in dueTasks"
                            :key="task.id"
                            class="rounded border p-4"
                        >
                            <h3 class="font-medium">{{ task.title }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

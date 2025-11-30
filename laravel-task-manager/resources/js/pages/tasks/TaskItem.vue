<script setup lang="ts">
import type { Project, Task } from '@/types';
import { formatDate, truncateText } from '@/lib/utils';
import { Button } from '@/components/ui/button';
import { defineProps, defineEmits } from 'vue';
import priorityToLabelMap from '@/enums/TaskPriority';
import TaskStatus from '@/enums/TaskStatus';

const props = defineProps<{
    project: Project;
    task: Task;
}>();

const { project, task } = props;

const emit = defineEmits(["task-edit", "task-deleted", "update-task"]);

function handleUpdate() {
    emit("task-edit", project.id, task.id);
}

function handleDelete() {
    if (confirm("Tem certeza que deseja deletar esta tarefa?")) {
        emit("task-deleted", project.id, task.id);
    }
}

function markAsDone() {
    emit("update-task", project.id, task.id, { status: TaskStatus.COMPLETED });
}

function getBackgroundColorByStatus(status: number): string {
    switch (status) {
        case 1:
            return "#fff3cd";
        case 2:
            return "#cce5ff";
        case 3:
            return "#d4edda";
    }

    return "#ffffff";
}
</script>

<template>
    <div class="rounded border p-4" :style="{ backgroundColor: getBackgroundColorByStatus(task.status) }">
        <div class="flex items-start justify-between">
            <h3 class="text-lg font-semibold">{{ task.title }}</h3>

            <div class="text-sm text-gray-500">
                <span>{{ formatDate(task.due_date) }}</span>
            </div>
        </div>

        <p class="mt-2 text-sm text-gray-700">{{ truncateText(task.description, 80) }}</p>
        <p class="mt-2 text-sm">Prioridade: {{ priorityToLabelMap[task.priority] }}</p>

        <div class="flex items-start justify-between mt-3">
            <div>
                <a v-if="task.file" :href="`/storage/${task.file}`" target="_blank" rel="noopener noreferrer"
                    class="text-sm text-indigo-600 hover:underline">
                    Visualizar arquivo
                </a>

                <span v-else class="text-sm text-gray-500">Nenhum arquivo anexado</span>
            </div>

            <div class="flex gap-2 ml-auto">
                <div class="flex gap-2">
                    <Button variant="outline" size="sm" @click="markAsDone" :disabled="task.status === TaskStatus.COMPLETED">
                        Marcar como concluída
                    </Button>

                    <Button variant="outline" size="sm" @click="handleUpdate">
                        Atualizar
                    </Button>
                </div>

                <div class="flex gap-2">
                    <Button variant="outline" size="sm" @click="handleDelete">
                        Deletar
                    </Button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import type { Project } from '@/types';
import { formatDate, truncateText } from '@/lib/utils';

const props = defineProps<{
    project: Project;
}>();

const { project } = props;
</script>

<template>
    <div class="rounded border p-4">
        <div class="flex items-start justify-between">
            <h3 class="text-lg font-semibold">{{ project.title }}</h3>
            <div class="text-sm text-gray-500">
                <span>{{ formatDate(project.start_date) }} — {{ formatDate(project.end_date) }}</span>
            </div>
        </div>

        <p class="mt-2 text-sm text-gray-700">{{ truncateText(project.description, 120) }}</p>

        <div class="mt-3">
            <a v-if="project.file" :href="`/storage/${project.file}`" target="_blank" rel="noopener noreferrer"
                class="text-sm text-indigo-600 hover:underline">
                Visualizar arquivo
            </a>
            <span v-else class="text-sm text-gray-500">Nenhum arquivo anexado</span>
        </div>
    </div>
</template>

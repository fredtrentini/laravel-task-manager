<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { defineProps, defineEmits, computed } from 'vue';
import type { Project, Task } from '@/types';
import { datetimeToFieldDate } from '@/lib/utils';
import priorityToLabelMap from '@/enums/TaskPriority';

const props = defineProps<{ 
    form: Record<string, any>;
    project: Project;
    task?: Task;
}>();

const emit = defineEmits(["go-back"]);

const task = props.task ?? {
    title: '',
    description: '',
    due_date: '',
    priority: 1,
    status: 1,
    file: null,
};

task.due_date = datetimeToFieldDate(task.due_date);

const form = {
    ...props.form,
    ...task,
}

const isEdit = computed(() => {
  return props.task != null;
})

function goBack() {
    emit("go-back");
}
</script>

<template>
    <Form v-bind="props.form" v-slot="{ errors, processing }" @success="goBack" class="rounded border p-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-medium">{{ isEdit ? "Editar tarefa" : "Criar tarefa" }}</h2>
        </div>

        <div class="grid gap-3">
            <div class="grid gap-1">
                <Label for="title">Título</Label>
                <Input v-model="form.title" id="title" name="title" type="text" required />
                <InputError :message="errors.title" />
            </div>

            <div class="grid gap-1">
                <Label for="description">Descrição</Label>
                <textarea v-model="form.description" id="description" name="description" class="w-full rounded border p-2" rows="3" required></textarea>
                <InputError :message="errors.description" />
            </div>

            <div class="grid gap-3">
                <div>
                    <Label for="due_date">Data de vencimento</Label>
                    <Input v-model="form.due_date" id="due_date" name="due_date" type="date" required />
                    <InputError :message="errors.due_date" />
                </div>
            </div>
            
            <div class="grid gap-1">
                <Label for="priority">Prioridade</Label>
                <select v-model.number="form.priority" id="priority" name="priority" class="w-full rounded border p-2" required>
                    <option v-for="[priority, label] in Object.entries(priorityToLabelMap)" :key="priority" :value="priority">
                        {{ label }}
                    </option>
                </select>
                <InputError :message="errors.priority" />
            </div>

            <div class="grid gap-1">
                <Label for="file">Arquivo</Label>
                <Input
                    id="file"
                    name="file"
                    type="file"
                    @change="form.file = $event.target.files[0]"
                    :required="!isEdit"
                />
                <InputError :message="errors.file" />
            </div>

            <div class="flex items-center gap-2">
                <Button type="submit" :disabled="processing" >
                    <Spinner v-if="processing" />
                    {{ isEdit ? "Atualizar" : "Criar" }} tarefa
                </Button>

                <Button type="button" @click="goBack">Cancelar</Button>
            </div>
        </div>
    </Form>
</template>

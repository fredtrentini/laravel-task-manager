<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { defineProps, defineEmits, computed } from 'vue';
import type { Project } from '@/types';
import { datetimeToFieldDate } from '@/lib/utils';

const props = defineProps<{ 
    form: Record<string, any>;
    project?: Project;
}>();

const emit = defineEmits(["go-back"]);

const project = props.project ?? {
    title: '',
    description: '',
    start_date: '',
    end_date: '',
    file: null,
};

project.start_date = datetimeToFieldDate(project.start_date);
project.end_date = datetimeToFieldDate(project.end_date);

const form = {
    ...props.form,
    ...project,
}

const isEdit = computed(() => {
  return props.project != null;
})

function goBack() {
    emit("go-back");
}
</script>

<template>
    <Form v-bind="props.form" v-slot="{ errors, processing }" @success="goBack" class="rounded border p-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-medium">{{ isEdit ? "Editar projeto" : "Criar projeto" }}</h2>
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

            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <Label for="start_date">Data de início</Label>
                    <Input v-model="form.start_date" id="start_date" name="start_date" type="date" required />
                    <InputError :message="errors.start_date" />
                </div>
                <div>
                    <Label for="end_date">Data de término</Label>
                    <Input v-model="form.end_date" id="end_date" name="end_date" type="date" required />
                    <InputError :message="errors.end_date" />
                </div>
            </div>

            <div class="grid gap-1">
                <Label for="file">Arquivo</Label>
                <Input id="file" name="file" type="file" @change="form.file = $event.target.files[0]" />
                <InputError :message="errors.file" />
            </div>

            <div class="flex items-center gap-2">
                <Button type="submit" :disabled="processing" >
                    <Spinner v-if="processing" />
                    {{ isEdit ? "Atualizar" : "Criar" }} projeto
                </Button>

                <Button type="button" @click="goBack">Cancelar</Button>
            </div>
        </div>
    </Form>
</template>

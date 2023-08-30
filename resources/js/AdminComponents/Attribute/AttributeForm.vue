<template>
	<div class="mb-3">
		<label class="form-label">Name</label>
		<input class="form-control" v-model="form.name" placeholder="Name" />
		<FormError :error="form.errors.name" />
	</div>
	<button type="submit" class="btn btn-primary" @click="emit('submit')">
		Save
	</button>
</template>

<script setup lang="ts">
import { InertiaForm, useForm } from '@inertiajs/vue3';
import FormError from '../FormError.vue';
import { TAttributeForm } from '@/types/TAttribute';

const props = defineProps<{
	form: InertiaForm<TAttributeForm>;
}>();

const emit = defineEmits({
	submit: () => true
});
</script>

<style scoped></style>

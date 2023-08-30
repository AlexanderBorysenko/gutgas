<template>
	<div>
		<div class="mb-3">
			<label class="form-label">Name</label>
			<input class="form-control" v-model="form.name" />
			<FormError :error="form.errors.name" />
		</div>
		<div class="mb-3">
			<div class="form-check">
				<input
					class="form-check-input"
					type="checkbox"
					v-model="form.use_in_filters"
					id="use_in_filters"
				/>
				<label class="form-check-label" for="use_in_filters">
					Use in filters
				</label>
			</div>
			<FormError :error="form.errors.use_in_filters" />
		</div>
		<button type="submit" class="btn btn-success" @click="emit('submit')">
			Save
		</button>
	</div>
</template>

<script setup lang="ts">
import { TAttributeGroupForm } from '@/types/TAttributeGroup';
import { InertiaForm } from '@inertiajs/vue3';
import FormError from '../FormError.vue';

const props = defineProps<{
	form: InertiaForm<TAttributeGroupForm>;
}>();

const emit = defineEmits({
	submit: () => true
});
</script>

<style scoped></style>

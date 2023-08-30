<template>
	<div>
		<div class="row">
			<div class="col-2">
				<FormFieldWrapper label="OG Image" class="mb-3">
					<MediaFileUrlSelect class="mb-1" v-model="form.og_image" />
				</FormFieldWrapper>
			</div>
			<div class="col-10">
				<FormFieldWrapper label="Title" class="mb-3">
					<input
						class="form-control"
						v-model="form.title"
						placeholder="Title"
					/>
					<FormError
						v-if="form.errors.title"
						class="mt-1"
						:error="form.errors.title"
					/>
				</FormFieldWrapper>
				<FormFieldWrapper label="Description" class="mb-3">
					<textarea
						class="form-control"
						v-model="form.description"
						placeholder="Description"
					/>
					<FormError
						v-if="form.errors.description"
						class="mt-1"
						:error="form.errors.description"
					/>
				</FormFieldWrapper>
			</div>
		</div>
		<FormFieldWrapper label="Slug" class="mb-3">
			<input
				class="form-control"
				v-model="form.slug"
				placeholder="Slug"
			/>
			<FormError
				v-if="form.errors.slug"
				class="mt-1"
				:error="form.errors.slug"
			/>
		</FormFieldWrapper>
	</div>
</template>

<script setup lang="ts">
import { TSeoEntityForm } from '@/types/TSeoEntity';
import FormFieldWrapper from '../FormFieldWrapper.vue';
import MediaFileUrlSelect from '../Media/MediaFileUrlSelect.vue';
import FormError from '../FormError.vue';
import { InertiaForm } from '@inertiajs/vue3';

const props = defineProps<{
	form: InertiaForm<TSeoEntityForm>;
}>();
</script>

<style scoped></style>

<template>
	<div>
		<Link
			:href="route('admin.page.edit', page.id) || ''"
			type="button"
			class="btn w-100 mb-1"
			:class="{
				'btn-primary': route().current('admin.page.edit'),
				'btn-outline-primary': !route().current('admin.page.edit')
			}"
		>
			General Data
		</Link>
		<Link
			:href="
				route('admin.seoEntity.forPage.edit', page.seo_entity?.id) || ''
			"
			type="button"
			class="btn w-100"
			:class="{
				'btn-primary': route().current('admin.seoEntity.forPage.edit'),
				'btn-outline-primary': !route().current(
					'admin.seoEntity.forPage.edit'
				)
			}"
		>
			SEO Data
		</Link>
		<a
			class="btn btn-outline-primary w-100 mt-1"
			target="_blank"
			:href="`/` + page.seo_entity?.slug"
		>
			View Page
		</a>
		<!-- delete -->
		<button
			type="button"
			class="btn btn-danger w-100 mt-1"
			@click="deletePage"
		>
			Delete
		</button>
	</div>
</template>

<script setup lang="ts">
import { TPage } from '@/types/TPage';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps<{
	page: TPage;
}>();

const deletePage = () => {
	if (confirm('Are you sure you want to delete this page?')) {
		router.delete(route('admin.page.destroy', props.page.id));
	}
};
</script>

<style scoped></style>

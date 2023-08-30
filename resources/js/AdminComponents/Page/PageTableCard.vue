<template>
	<tr>
		<td>{{ page.id }}</td>
		<td>
			<a
				v-if="page.seo_entity.slug"
				target="_blank"
				:href="route('seo-entity', page.seo_entity.slug)"
			>
				{{ _t(page.title) || 'Untitled' }}
			</a>
			<span v-else>{{ _t(page.title) || 'Untitled' }}</span>
		</td>
		<td>
			{{ page.seo_entity.slug || 'No Slug' }}
		</td>
		<td>
			{{ page.type || 'No Type' }}
		</td>
		<td class="text-right">
			<div class="btn-group">
				<Link
					:href="route('admin.page.edit', page.id) || ''"
					class="btn btn-primary border-dark"
					>Page
				</Link>
				<Link
					:href="
						route(
							'admin.seoEntity.forPage.edit',
							page.seo_entity?.id
						) || ''
					"
					class="btn btn-primary border-dark"
					>SEO
				</Link>
				<button
					class="btn btn-danger border-dark"
					@click="onPageDelete"
				>
					Delete
				</button>
			</div>
		</td>
	</tr>
</template>

<script setup lang="ts">
import { TPage } from '@/types/TPage';
import { Link, router } from '@inertiajs/vue3';

const { _t } = useTranslations();

const props = defineProps<{
	page: TPage;
}>();

const onPageDelete = () => {
	if (confirm('Are you sure you want to delete this page?')) {
		router.delete(route('admin.page.destroy', props.page.id));
	}
};
</script>

<style scoped></style>

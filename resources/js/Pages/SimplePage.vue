<template>
	<title>{{ _t(page.seo_entity.title ?? page.title) }}</title>
	<link
		rel="canonical"
		:href="
			route('seo-entity', [usePage().props.locale, page.seo_entity.slug])
		"
	/>
	<meta name="description" :content="_t(page.seo_entity.description ?? '')" />
	<meta
		property="og:title"
		:content="_t(page.seo_entity.title ?? page.title)"
	/>
	<meta
		property="og:description"
		:content="_t(page.seo_entity.description ?? '')"
	/>
	<meta property="og:type" content="website" />
	<meta
		property="og:url"
		:content="
			route('seo-entity', [usePage().props.locale, page.seo_entity.slug])
		"
	/>
	<meta
		v-if="page.seo_entity.og_image"
		property="og:image"
		:content="page.seo_entity.og_image"
	/>
	<WebsitePage>
		<PageHeadSpacer class="mb-60" />
		<div class="container">
			<h1 class="fs-h1 mb-48">{{ _t(page.title) }}</h1>
		</div>
		<PageContentSection class="mb-48">
			<div v-html="_t(page.content)"></div>
		</PageContentSection>
	</WebsitePage>
</template>

<script setup lang="ts">
import WebsitePage from '@/Layouts/WebsitePage.vue';
import { TPage } from '@/types/TPage';
import PageContentSection from '@/Components/PageContentSection.vue';
import { getMeta } from '@/utils/getMeta';
import PageHeadSpacer from '@/Components/PageHeadSpacer.vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps<{
	page: TPage;
}>();

const { _t } = useTranslations();
</script>

<style scoped></style>

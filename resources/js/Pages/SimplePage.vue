<template>
	<Head>
		<SeoEntityMetaFields :seo-entity="page.seo_entity" />
	</Head>
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
import { Head, usePage } from '@inertiajs/vue3';
import SeoEntityMetaFields from '@/Components/SeoEntityMetaFields.vue';

const props = defineProps<{
	page: TPage;
}>();

const { _t } = useTranslations();
</script>

<style scoped></style>

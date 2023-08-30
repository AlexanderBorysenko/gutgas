<template>
	<Head>
		<title>{{ _t(page.seo_entity.title) }}</title>
		<meta name="description" :content="_t(page.seo_entity.description)" />
		<meta
			v-if="page.seo_entity.og_image"
			property="og:image"
			:content="page.seo_entity.og_image"
		/>
		<link rel="canonical" :href="baseUrl + '/' + page.seo_entity.slug" />
		<link
			rel="prev"
			:href="productsCatalogData.products.prev_page_url"
			v-if="productsCatalogData.products.prev_page_url"
		/>
		<link
			rel="next"
			:href="productsCatalogData.products.next_page_url"
			v-if="productsCatalogData.products.next_page_url"
		/>
	</Head>
	<WebsitePage>
		<PageHeadSpacer class="mb-60" />
		<section class="container mb-88">
			<h2 class="fs-h2 mb-68">{{ _t(page.title) }}</h2>
			<div ref="productsCatalogLayoutRef">
				<ProductsCatalog
					:catalog-slug="page.seo_entity.slug"
					:products-catalog-data="productsCatalogData"
					:preview-sections="
						getMeta(page.meta, 'catalogPreviewItems') || []
					"
					mode="catalogFull"
				/>
			</div>
		</section>

		<PageSeparator class="mb-116" />
		<PageContentSection
			class="mb-48"
			:title="getMeta(page.meta, 'contentTitle') || _t(page.title)"
		>
			<div v-html="_t(page.content)"></div>
		</PageContentSection>
		<PageSeparator v-if="faqItems.length" class="mb-116" />
		<FaqSection v-if="faqItems" :faq-items="faqItems" class="mb-116" />
		<PageSeparator class="mb-116" />
	</WebsitePage>
</template>

<script setup lang="ts">
import WebsitePage from '@/Layouts/WebsitePage.vue';
import PageSeparator from '@/Components/PageSeparator.vue';
import PageHeadSpacer from '@/Components/PageHeadSpacer.vue';
import PageContentSection from '@/Components/PageContentSection.vue';
import FaqSection from '@/Components/FaqSection.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { TPage } from '@/types/TPage';
import { getMeta } from '@/utils/getMeta';
import { TFaqItemProps } from '@/types/TFaqItemProps';
import { TproductsCatalogData } from '@/types/TproductsCatalogData';
import ProductsCatalog from '@/Components/ProductsCatalog.vue';

const { _t, __ } = useTranslations();

const { baseUrl } = usePage().props;

const props = defineProps<{
	productsCatalogData: TproductsCatalogData;
	page: TPage;
}>();

const faqItems = getMeta<TFaqItemProps[]>(props.page.meta, 'faqItems') || [];
</script>

<style scoped></style>

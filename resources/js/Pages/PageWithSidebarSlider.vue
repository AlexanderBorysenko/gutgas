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
		<div class="container mb-72">
			<div class="g-layout content-layout">
				<div class="g-col-6 g-large-mobile-col-12">
					<div
						class="typography-content fs-typography-content lh-210 color-typography-secondary"
						ref="contentRef"
					>
						<div v-html="_t(page.content)" />
					</div>
				</div>
				<div class="g-col-6">
					<ProductGallerySlider :images="images" class="mb-48" />
				</div>
			</div>
		</div>
		<ContactUsSection
			class="mb-116"
			:title="getMeta(page.meta, 'contactFormTitle')"
			:subtitle="getMeta(page.meta, 'contactFormSubTitle')"
			:text="getMeta(page.meta, 'contactFormText')"
		/>
		<AdvantagesSection
			:items="getMeta(page.meta, 'advantagesItems') || []"
			class="mb-116"
		/>
	</WebsitePage>
</template>

<script setup lang="ts">
import WebsitePage from '@/Layouts/WebsitePage.vue';
import { TPage } from '@/types/TPage';
import PageHeadSpacer from '@/Components/PageHeadSpacer.vue';
import ProductGallerySlider from '@/Components/ProductGallerySlider.vue';
import { getMeta } from '@/utils/getMeta';
import { ref } from 'vue';
import ContactUsSection from '@/Components/ContactUsSection.vue';
import AdvantagesSection from '@/Components/AdvantagesSection.vue';
import { IMediaFile } from '@/types/IMediaFile';
import { usePage } from '@inertiajs/vue3';

const props = defineProps<{
	page: TPage;
}>();

console.log(getMeta<string[]>(props.page.meta, 'sidebarSliderImages'));

const images = ref<string[]>(
	getMeta<IMediaFile[]>(props.page.meta, 'sidebarSliderImages')?.map(
		mediaFile => mediaFile.url
	) || []
);

const { _t } = useTranslations();
</script>

<style scoped lang="scss">
.content-layout {
	gap: 4rem;
}
</style>

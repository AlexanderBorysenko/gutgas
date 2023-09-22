<template>
	<title>{{ _t(seoEntity.title) }}</title>
	<link
		rel="canonical"
		:href="route('seo-entity', [usePage().props.locale, seoEntity.slug])"
	/>
	<meta name="description" :content="_t(seoEntity.description)" />
	<meta property="og:title" :content="_t(seoEntity.title)" />
	<meta property="og:description" :content="_t(seoEntity.description)" />
	<meta property="og:type" content="website" />
	<meta
		property="og:url"
		:content="route('seo-entity', [usePage().props.locale, seoEntity.slug])"
	/>
	<meta
		v-if="seoEntity.og_image"
		property="og:image"
		:content="seoEntity.og_image"
	/>
	<meta
		property="og:locale"
		:content="
			usePage().props.locale + '_' + usePage().props.locale.toUpperCase()
		"
	/>
</template>

<script setup lang="ts">
import { TSeoEntity } from '@/types/TSeoEntity';
import { usePage } from '@inertiajs/vue3';

const { _t } = useTranslations();

const props = defineProps<{
	seoEntity: TSeoEntity;
}>();
</script>

<style scoped></style>

<template>
	<nav class="products-groups-menu">
		<ul class="f-row justify-center">
			<li class="products-group-card">
				<ProductsGroupCard
					:name="__('all')"
					:icon="defaultIcon"
					:iconHover="defaultIconHover"
					:iconActive="defaultIconActive"
					:disableLink="reactiveFilterMode"
					:active="
						reactiveFilterMode
							? !currentProductsGroup
							: currentPath ===
							  getGlobalSetting('productsCatalogSlug')
					"
					@click="e => onProductsGroupSelect(e, null)"
				/>
				<Link
					v-if="!reactiveFilterMode"
					:href="
						getGlobalSetting('productsCatalogSlug') || '/catalog'
					"
					class="card-link"
				>
					{{ __('catalog') }}
				</Link>
			</li>
			<li
				class="products-group-card"
				v-for="productsGroup in productsGroups"
				:key="productsGroup.id"
			>
				<ProductsGroupCard
					:icon="productsGroup.icon"
					:iconHover="productsGroup.icon_hover"
					:iconActive="productsGroup.icon_active"
					:name="_t(productsGroup.name)"
					:disableLink="reactiveFilterMode"
					:active="
						reactiveFilterMode
							? +currentProductsGroup === productsGroup.id
							: currentPath ===
							  '/' + productsGroup.seo_entity.slug
					"
					@click="e => onProductsGroupSelect(e, productsGroup.id)"
					class="products-group-card"
				/>
				<Link
					v-if="!reactiveFilterMode"
					:href="'/' + productsGroup.seo_entity.slug"
					class="card-link"
				>
					{{ _t(productsGroup.name) }}
				</Link>
			</li>
		</ul>
	</nav>
</template>

<script setup lang="ts">
import ProductsGroupCard from './ProductsGroupCard.vue';
import { TProductsGroup } from '@/types/TProductsGroup';

import defaultIcon from '@/assets/product-categories/all-balons.svg';
import defaultIconActive from '@/assets/product-categories/all-balons-active.svg';
import defaultIconHover from '@/assets/product-categories/all-balons-hover.svg';
import { getGlobalSetting } from '@/utils/getGlobalSetting';

import { Link, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const { _t, __ } = useTranslations();

const props = defineProps<{
	productsGroups: TProductsGroup[];
	reactiveFilterMode?: boolean;
	selectedProductsGroup?: number | null;
}>();

const currentProductsGroup = (usePage().props as any).productsCatalogData
	.productsGroup;

const currentPath = ref<string>(
	hasWindow()
		? window.location.pathname.replace(usePage().props.locale + '/', '')
		: ''
);

const onProductsGroupSelect = (e: Event, id: number | null) => {
	if (!props.reactiveFilterMode) return;
	emit('productsGroupSelect', id);
};

const emit = defineEmits({
	productsGroupSelect: (id: number | null) => true
});
</script>

<style scoped lang="scss">
@import '@/styles/variables.scss';
.f-row {
	--col-gap: 24px;
	--row-gap: 24px;
	@media (max-width: $tablet-width) {
		--col-gap: 16px;
		--row-gap: 16px;
	}
}
.products-group-card {
	flex-basis: 160px;
	position: relative;
	@media (max-width: $tablet-width) {
		flex-basis: 100px;
	}
}
.card-link {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	z-index: 10;
	opacity: 0;
}
</style>

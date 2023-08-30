<template>
	<nav class="desktop-header-menu">
		<Link
			:href="item.url || ''"
			class="menu-item"
			:class="{
				active:
					(activePath === '/' && item.url === '/') ||
					(item.url !== '/' && activePath.includes(item.url))
			}"
			v-for="item in items"
		>
			{{ __(item.title) }}
		</Link>
	</nav>
</template>

<script setup lang="ts">
import { THeaderMenuItem } from '@/types/THeaderMenu';
import { getGlobalSetting } from '@/utils/getGlobalSetting';
import { Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { ref } from 'vue';

const { __ } = useTranslations();

const items = getGlobalSetting<THeaderMenuItem[]>('headerMenu') ?? [];
const activePath = ref(hasWindow() ? location.pathname : '');
onMounted(() => {
	activePath.value = location.pathname;
});
</script>

<style scoped lang="scss">
@import '@/styles/variables.scss';
.desktop-header-menu {
	display: flex;
}
.menu-item {
	color: #bdbdbd;
	position: relative;
	padding-bottom: 8px;
	transition: color 0.2s ease-in-out;
	margin-right: 1.5rem;
	@media (max-width: $small-desktop-width) {
		margin-right: 1rem;
	}
	&::before {
		content: '';
		width: 100%;
		position: absolute;
		bottom: 0;
		transform: scaleX(0);
		height: 2px;
		border-radius: 2px;
		background-color: #f24942;
		transition: transform 0.2s ease-in-out,
			background-color 0.2s ease-in-out;
	}
	&:hover {
		&::before {
			transform: scaleX(1);
		}
	}
	&.active {
		color: #ffffff;
		&::before {
			transform: scaleX(1);
		}
	}
}
</style>

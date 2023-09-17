<template>
	<div class="container">
		<nav class="base-breadcrumbs fw-600 lh-150">
			<template v-for="breadcrumb in breadcrumbs">
				<Link
					v-if="currentUrl !== '/' + breadcrumb.slug"
					:href="breadcrumb.slug || ''"
					class="item"
				>
					{{ breadcrumb.title }}
				</Link>
				<span class="item" v-else>{{ breadcrumb.title }}</span>
			</template>
		</nav>
	</div>
</template>

<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { onMounted } from 'vue';
const {
	props: { breadcrumbs }
} = usePage();

const currentUrl = ref('');
onMounted(() => {
	currentUrl.value = window.location.href.replace(window.location.origin, '');
});
</script>

<style scoped lang="scss">
.base-breadcrumbs {
	display: flex;
	align-items: center;
}
.item {
	color: #b73e38;
	display: flex;
	align-items: center;
	position: relative;
}
a.item {
	&:hover {
		text-decoration: underline;
	}
	&::after {
		content: '';
		display: block;
		position: relative;
		background: url('@/assets/breadcrumbs-separator.svg') no-repeat center;
		width: 16px;
		height: 16px;
		margin: 0 6px 0 4px;
	}
}
span.item {
	opacity: 0.5;
}
</style>

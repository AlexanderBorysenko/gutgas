<template>
	<div class="navigation-modal-menu ph-16">
		<ul>
			<li v-for="item in items">
				<router-link
					class="pv-16"
					:class="{ active: item.isActive }"
					:to="item.href"
					@click="toggleNavigationModal"
					>{{ item.name }}</router-link
				>
			</li>
		</ul>
	</div>
</template>

<script setup lang="ts">
import useNavigationModal from '@/composables/navigationModal';

const { items, toggleNavigationModal } = useNavigationModal();
</script>

<style scoped lang="scss">
.navigation-modal-menu {
	height: 100%;
	overflow-y: auto;
}
a {
	display: block;
	border-bottom: 1px solid rgba($color: #fff, $alpha: 0.2);
	transition: color 0.3s ease-in-out, border-bottom 0.3s ease-in-out;
	&.active {
		color: #f24942;
		border-bottom: 1px solid #f24942;
	}
}
</style>

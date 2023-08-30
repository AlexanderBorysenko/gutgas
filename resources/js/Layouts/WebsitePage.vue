<template>
	<HeaderDesktop />
	<MobileOverlay class="mobile-overlay" />
	<slot />
	<TheFooter />
	<NavigationModal />
</template>

<script setup lang="ts">
import NavigationModal from '@/Components/NavigationModal.vue';
import TheFooter from '@/Components/TheFooter.vue';
import useCart from '@/composables/cart';
import '@/styles/style.scss';
import MobileOverlay from '@/Components/MobileOverlay.vue';
import HeaderDesktop from '@/Components/HeaderDesktop.vue';
import { Head } from '@inertiajs/vue3';

const { setupCart } = useCart();
setupCart();
</script>

<style scoped lang="scss"></style>

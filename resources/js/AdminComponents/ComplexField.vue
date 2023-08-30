<template>
	<div class="complex-field">
		<slot />
	</div>
</template>

<script setup lang="ts">
const props = defineProps<{
	modelValue: any[];
}>();
</script>

<style scoped></style>

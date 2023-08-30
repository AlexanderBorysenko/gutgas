<template>
	<div class="page-head-spacer"></div>
</template>

<script setup lang="ts"></script>

<style scoped lang="scss">
@import '@/styles/variables.scss';

.page-head-spacer {
	height: 1px;
	max-width: 1376px;
	width: 100%;
	margin-left: auto;
	margin-right: auto;
	margin-top: 128px;
	background: #1a1a1a;
	@media (max-width: $tablet-width) {
		margin-top: 80px;
	}
}
</style>

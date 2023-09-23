<template>
	<div class="g-layout contacts-layout">
		<template v-for="contactItem in items">
			<div class="g-col-6 pl-24">
				<p class="fs-medium fw-700">
					{{ contactItem.name }}
				</p>
			</div>
			<div class="g-col-6">
				<div
					v-for="(contactItemValue, index) in contactItem.values"
					:class="{
						'mb-12': index + 1 !== contactItem.values.length
					}"
				>
					<p class="fs-medium fw-700">
						{{ contactItemValue.value }}
					</p>
					<p class="fs-semi-small ls--1 color-secondary">
						{{ contactItemValue.comment }}
					</p>
				</div>
			</div>
		</template>
	</div>
</template>

<script setup lang="ts">
import { TContactItemProps } from '@/types/TContactItemProps';
import { getGlobalSetting } from '@/utils/getGlobalSetting';
import { ref } from 'vue';

const props = defineProps<{
	items?: TContactItemProps[];
}>();

const items = ref(
	props.items
		? props.items
		: getGlobalSetting<TContactItemProps[]>('contactItems') ?? []
);
</script>

<style scoped lang="scss">
@import '@/styles/variables';
.contacts-layout {
	column-gap: 20px;
	row-gap: 16px;
	@media (max-width: $small-desktop-width) {
		.g-col-6 {
			padding-left: 0;
		}
	}
}
</style>

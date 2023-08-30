<template>
	<AdminLayout>
		<!-- categories table -->
		<div class="mb-3">
			<Link
				class="btn btn-primary"
				:href="route('admin.requiredProductsGroup.create') || ''"
			>
				Create Required Products Group
			</Link>
		</div>
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Name</th>
						<th class="text-right">Actions</th>
					</tr>
				</thead>
				<tbody>
					<RequiredProductsGroupTableCard
						v-for="requiredProductsGroup in requiredProductsGroups"
						:requiredProductsGroup="requiredProductsGroup"
						:key="requiredProductsGroup.id"
					/>
				</tbody>
			</table>
		</div>
	</AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';
import { TRequiredProductsGroup } from '@/types/TRequiredProductsGroup';
import RequiredProductsGroupTableCard from '@/AdminComponents/RequiredProductsGroup/RequiredProductsGroupTableCard.vue';

const props = defineProps<{
	requiredProductsGroups: TRequiredProductsGroup[];
}>();
</script>

<style scoped></style>

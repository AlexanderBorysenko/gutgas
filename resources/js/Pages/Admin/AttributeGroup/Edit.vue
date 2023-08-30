<template>
	<AdminLayout>
		<AttributeGroupForm :form="form" @submit="onSubmitForm" class="mb-3" />
		<div class="mb-3">
			<h2>Attributes</h2>
			<div class="row">
				<div class="col-3">
					<AttributeForm
						:form="attributeForm"
						@submit="onSubmitAttributeForm"
					/>
				</div>
				<div class="col-9">
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Name</th>
									<th class="text-right">Actions</th>
								</tr>
							</thead>
							<tbody>
								<AttributeTableCard
									v-for="attribute in attributes"
									:attribute="attribute"
									:key="attribute.id"
								/>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</AdminLayout>
</template>

<script setup lang="ts">
import AttributeTableCard from '@/AdminComponents/Attribute/AttributeTableCard.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { TAttribute, TAttributeForm } from '@/types/TAttribute';
import { TAttributeGroup, TAttributeGroupForm } from '@/types/TAttributeGroup';
import AttributeGroupForm from '@/AdminComponents/AttributeGroup/AttributeGroupForm.vue';
import { useForm } from '@inertiajs/vue3';
import AttributeForm from '@/AdminComponents/Attribute/AttributeForm.vue';

const { _t } = useTranslations();

const props = defineProps<{
	attributeGroup: TAttributeGroup;
	attributes: TAttribute[];
}>();

const form = useForm<TAttributeGroupForm>({
	name: _t(props.attributeGroup.name),
	use_in_filters: props.attributeGroup.use_in_filters === 1
});

const onSubmitForm = () => {
	form.clearErrors();
	form.put(route('admin.attributeGroup.update', props.attributeGroup.id));
};

const attributeForm = useForm<TAttributeForm>({
	name: '',
	attribute_group_id: props.attributeGroup.id
});

const onSubmitAttributeForm = () => {
	attributeForm.clearErrors();
	attributeForm.post(route('admin.attribute.store'));
};
</script>

<style scoped></style>
@/types/TAttributeGroup

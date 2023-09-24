<template>
	<tr>
		<td>
			<div v-if="isEdit">
				<input v-model="form.name" class="form-control" type="text" />
				<FormError class="mb-0" :error="form.errors.name" />
			</div>
			<span v-else>{{ _t(attribute.name) }}</span>
		</td>
		<td class="text-right">
			<div
				class="btn-group"
				v-if="hasPermissions('admin.attribute.manage')"
			>
				<button
					v-if="isEdit"
					@click="submitForm"
					class="btn btn-success"
				>
					Зберегти
				</button>
				<button class="btn btn-primary" @click="isEdit = !isEdit">
					{{ isEdit ? 'Discard Changes' : 'Edit' }}
				</button>
				<Link
					class="btn btn-danger"
					:href="route('admin.attribute.destroy', attribute.id) || ''"
					method="delete"
					as="button"
				>
					Видалити
				</Link>
			</div>
		</td>
	</tr>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { TAttribute, TAttributeForm } from '@/types/TAttribute';
import useAuth from '@/modules/useAuth';
import { Link, useForm } from '@inertiajs/vue3';
import FormError from '../FormError.vue';

const { _t } = useTranslations();

const props = defineProps<{
	attribute: TAttribute;
}>();

const isEdit = ref(false);

const form = useForm<TAttributeForm>({
	name: _t(props.attribute.name)
});

const submitForm = () => {
	form.clearErrors();
	form.put(route('admin.attribute.update', props.attribute.id), {
		preserveScroll: true,
		onSuccess: () => {
			isEdit.value = false;
		}
	});
};

const { hasPermissions } = useAuth();
</script>

<style scoped></style>

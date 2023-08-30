<template>
	<div class="row">
		<div class="col-2">
			<label class="form-label">Main Image</label>
			<MediaFileSelect v-model="form.media_file" />
		</div>
		<div class="col-10">
			<div class="row mb-3">
				<div class="col-8">
					<label class="form-label">Name</label>
					<input
						class="form-control fs-4"
						v-model="form.name"
						placeholder="Name"
					/>
					<FormError :error="form.errors.name" />
				</div>
				<div class="col-4">
					<label class="form-label">SKU</label>
					<input
						class="form-control fs-4"
						v-model="form.sku"
						placeholder="SKU"
					/>
					<FormError :error="form.errors.sku" />
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-8">
					<label class="form-label">Short Description</label>
					<textarea
						class="form-control"
						v-model="form.description"
						placeholder="Description"
					></textarea>
				</div>
				<div class="col-4">
					<label class="form-label">Price</label>
					<input
						class="form-control"
						v-model="form.price"
						placeholder="Price"
					/>
					<FormError :error="form.errors.price" />
					<label class="form-label mt-3">Stock</label>
					<input
						class="form-control"
						v-model="form.stock"
						placeholder="Stock"
					/>
					<FormError :error="form.errors.stock" />
				</div>
			</div>
		</div>
	</div>
	<FormFieldWrapper label="Category" class="mb-3">
		<CategorySelect
			class="mb-4"
			:categories="categories"
			v-model="form.category_id"
		/>
	</FormFieldWrapper>
	<FormFieldWrapper label="Attributes" class="mb-3">
		<AttributeMultiSelect
			:attributes="attributes"
			v-model="form.attributes"
		/>
	</FormFieldWrapper>
	<FormFieldWrapper
		label="Products Group"
		class="mb-3"
		v-if="productsGroups.length"
	>
		<ProductsGroupMultiSelect
			:productsGroups="productsGroups"
			v-model="form.products_groups"
		/>
	</FormFieldWrapper>
	<FormFieldWrapper
		label="Required Products Group"
		class="mb-3"
		v-if="requiredProductsGroups.length"
	>
		<RequiredProductsGroupMultiSelect
			:requiredProductsGroups="requiredProductsGroups"
			v-model="form.required_products_groups"
		/>
	</FormFieldWrapper>
</template>

<script setup lang="ts">
import { TAttribute } from '@/types/TAttribute';
import { ICategoryTree } from '@/types/ICategoryTree';
import { InertiaForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import CategorySelect from '../Category/CategorySelect.vue';
import AttributeMultiSelect from '../Attribute/AttributeMultiSelect.vue';
import MediaFileSelect from '../Media/MediaFileSelect.vue';
import FormError from '../FormError.vue';
import { TProductForm } from '@/types/TProduct';
import FormFieldWrapper from '../FormFieldWrapper.vue';
import { TProductsGroup } from '@/types/TProductsGroup';
import ProductsGroupMultiSelect from '../ProductsGroup/ProductsGroupMultiSelect.vue';
import { TRequiredProductsGroup } from '@/types/TRequiredProductsGroup';
import RequiredProductsGroupMultiSelect from '../RequiredProductsGroup/RequiredProductsGroupMultiSelect.vue';

const editMode = ref<'general' | 'page' | 'seo'>('general');
const props = defineProps<{
	form: InertiaForm<TProductForm>;
	attributes: TAttribute[];
	categories: ICategoryTree[];
	productsGroups: TProductsGroup[];
	requiredProductsGroups: TRequiredProductsGroup[];
}>();
</script>

<style scoped lang="scss"></style>

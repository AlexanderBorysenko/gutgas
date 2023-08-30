<template>
	<div>
		<div class="row">
			<div class="col-3 mb-3" v-for="(item, index) in items">
				<div class="card-body" :key="index">
					<div class="mb-1">
						<div class="d-flex gap-1">
							<div class="flex-grow-1">
								<label for="">Image</label>
								<MediaFileUrlSelect v-model="item.image" />
							</div>
							<div class="flex-grow-1">
								<label for="">Logo</label>
								<MediaFileUrlSelect
									class="mb-1"
									v-model="item.logo"
								/>
							</div>
						</div>
						<!-- title -->
						<input
							type="text"
							class="form-control mb-1"
							placeholder="Title"
							v-model="item.title"
						/>
						<!-- is recomended -->
						<div class="form-check form-switch mb-1">
							<input
								class="form-check-input"
								type="checkbox"
								v-model="item.recommended"
							/>
							<label class="form-check-label">
								Recommended
							</label>
						</div>
						<!-- is discouraged -->
						<div class="form-check form-switch mb-1">
							<input
								class="form-check-input"
								type="checkbox"
								v-model="item.discouraged"
							/>
							<label class="form-check-label">
								Discouraged
							</label>
						</div>
						<label for=""> Advantages (separate by ';') </label>
						<textarea
							class="form-control mb-1"
							rows="5"
							:value="item.advantages.join(';')"
							@input="(event: Event) => {
                                item.advantages = (event.target as HTMLTextAreaElement).value.split(';')}"
						></textarea>
						<label for=""> Disadvantages (separate by ';') </label>
						<textarea
							class="form-control mb-1"
							:value="item.disadvantages.join(';')"
							@input="(event: Event) => {
                            item.disadvantages = (event.target as HTMLTextAreaElement).value.split(';')}"
						></textarea>
						<button
							class="btn btn-danger"
							@click="items.splice(index, 1)"
						>
							Remove
						</button>
					</div>
				</div>
			</div>
		</div>
		<button
			class="btn btn-primary"
			@click="
				items.push({
					title: '',
					image: '',
					recommended: false,
					discouraged: false,
					logo: '',
					advantages: [],
					disadvantages: []
				})
			"
		>
			Add Pros Cons Item
		</button>
	</div>
</template>

<script setup lang="ts">
import { TProductProsConsCardProps } from '@/types/TProductProsConsCardProps';
import { toRef, watch } from 'vue';
import MediaFileUrlSelect from '../Media/MediaFileUrlSelect.vue';

// {
//     title: string;
//     image: string;
//     recommended?: boolean | undefined;
//     discouraged?: boolean | undefined;
//     logo?: string | undefined;
//     advantages: string[];
//     disadvantages: string[];
// }
const props = defineProps<{
	modelValue: TProductProsConsCardProps[];
}>();

const items = toRef(props, 'modelValue');

watch(
	() => items.value,
	value => {
		emit('update:modelValue', value);
	},
	{ deep: true }
);

const emit = defineEmits({
	'update:modelValue': (value: TProductProsConsCardProps[]) => true
});
</script>

<style scoped></style>

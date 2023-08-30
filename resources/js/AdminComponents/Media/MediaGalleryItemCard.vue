<template>
	<MediaFileCard
		:imageUrl="imageUrl"
		:name="mediaFile.name"
		:type="mediaFile.mime_type"
		:disabled="disabled"
		:class="{ selected }"
	>
		<template #controls>
			<button
				:class="[
					'btn',
					'btn-sm',
					{ 'btn-primary': selected, 'btn-secondary': !selected }
				]"
				@click="onSelect"
			>
				{{ selected ? 'Deselect' : 'Select' }}
			</button>
			<!-- <a :href="mediaFile.url" class="btn btn-primary">
				<i class="bi bi-eye"></i>
			</a> -->
			<button
				v-if="hasPermissions('admin.media.manage')"
				class="btn btn-danger"
				@click="onDelete()"
			>
				<i class="bi bi-trash"></i>
			</button>
			<!-- select button -->
		</template>
	</MediaFileCard>
</template>

<script setup lang="ts">
import { IMediaFile } from '@/types/IMediaFile';
import { PropType, computed, ref, watchEffect } from 'vue';
import { deleteMediaFile } from '@/api/mediaFileService';
import useAuth from '@/modules/useAuth';
import MediaFileCard from '@/AdminComponents/Media/MediaFileCard.vue';
import getMediaFileUrl from '@/modules/helpers/getMediaFileUrl';
import useMessages from '@/modules/useMessages';

const { hasPermissions } = useAuth();

const props = defineProps({
	mediaFile: {
		type: Object as PropType<IMediaFile>,
		required: true
	},
	selected: {
		type: Boolean,
		default: false
	},
	shouldBeDeleted: {
		type: Boolean,
		default: false
	}
});

const disabled = ref(false);

const imageUrl = computed(() => {
	if (props.mediaFile.mime_type.includes('image'))
		return getMediaFileUrl(props.mediaFile, 'thumbnail');

	return undefined;
});

const onDelete = async (force: boolean = false) => {
	if (!force && !confirm('Are you sure you want to delete this file?'))
		return;

	disabled.value = true;

	try {
		await deleteMediaFile(props.mediaFile.id);
		addMessage({
			type: 'success',
			text: `${props.mediaFile.name} deleted successfully`
		});
		emit('delete', props.mediaFile);
	} catch (e) {
		addMessage({
			type: 'error',
			text: `Error deleting ${props.mediaFile.name}`
		});
		console.error(e);
	}
	disabled.value = false;
};

watchEffect(() => {
	if (props.shouldBeDeleted) onDelete(true);
});

const onSelect = () => {
	emit('select', props.mediaFile);
};

const emit = defineEmits({
	delete: (mediaFile: IMediaFile) => true,
	select: (mediaFile: any) => true
});

const { addMessage } = useMessages();

defineExpose({ onDelete, mediaFile: props.mediaFile });
</script>

<style scoped lang="scss"></style>

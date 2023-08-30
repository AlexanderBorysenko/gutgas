<template>
	<AdminLayout>
		<FormFieldWrapper label="Status" class="mb-3">
			<div class="row g-1">
				<div class="col-4">
					<label class="form-label">Status Name</label>
					<input
						class="form-control"
						v-model="form.status_name"
						placeholder="Status"
					/>
					<FormError :error="form.errors.status_name" />
				</div>
				<div class="col-4">
					<label class="form-label">Status Color</label>
					<select
						v-model="form.status_color"
						class="form-control"
						placeholder="Status Color"
					>
						<option value="primary">primary</option>
						<option value="secondary">secondary</option>
						<option value="success">success</option>
						<option value="danger">danger</option>
						<option value="warning">warning</option>
						<option value="info">info</option>
						<option value="light">light</option>
						<option value="dark">dark</option>
					</select>
					<FormError :error="form.errors.status_color" />
				</div>
				<!-- compleated checkbox -->
				<div class="col-4">
					<div
						class="d-flex align-content-center justify-content-center h-100"
					>
						<div class="form-check mt-4">
							<input
								class="form-check-input"
								type="checkbox"
								v-model="form.compleated"
								id="flexCheckDefault"
							/>
							<label
								class="form-check-label"
								for="flexCheckDefault"
							>
								Compleated
							</label>
						</div>
					</div>
				</div>
			</div>
		</FormFieldWrapper>
		<FormFieldWrapper label="Client" class="mb-3">
			<div class="row g-1">
				<div class="col-6">
					<div class="mb-3">
						<label class="form-label">Name</label>
						<input
							class="form-control"
							v-model="form.client_name"
							placeholder="Name"
						/>
						<FormError :error="form.errors.client_name" />
					</div>
					<div class="mb-3">
						<label class="form-label">Phone</label>
						<input
							class="form-control"
							v-model="form.client_phone"
							placeholder="Phone"
						/>
						<FormError :error="form.errors.client_phone" />
					</div>
					<div class="mb-0">
						<label class="form-label">Email</label>
						<input
							class="form-control"
							v-model="form.client_email"
							placeholder="Email"
						/>
					</div>
				</div>
				<div class="col-6">
					<div class="mb-0 h-100">
						<textarea
							class="form-control h-100"
							v-model="form.client_message"
							placeholder="Message"
						></textarea>
					</div>
				</div>
			</div>
		</FormFieldWrapper>
		<FormFieldWrapper label="Content" class="mb-3">
			<table class="table table-responsive table-bordered mb-3">
				<thead>
					<tr>
						<th>id</th>
						<th>Image</th>
						<th>Name</th>
						<th>SKU</th>
						<th>Quantity</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="item in form.cart_content" :key="item.id">
						<td>{{ item.id }}</td>
						<td>
							<img
								:src="item.media_file?.thumbnail?.url"
								style="
									width: 50px;
									height: 50px;
									object-fit: cover;
								"
							/>
						</td>
						<td>{{ _t(item.name) }}</td>
						<td>{{ item.sku }}</td>
						<td>{{ item.quantity }}</td>
						<td>{{ item.price * item.quantity }} ₴</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="5" class="text-right"></td>
						<td>
							<strong>
								{{
									form.cart_content.reduce(
										(acc, item) =>
											acc + item.price * item.quantity,
										0
									)
								}}
								₴
							</strong>
						</td>
					</tr>
				</tfoot>
			</table>
		</FormFieldWrapper>
		<FormFieldWrapper
			label="Shipping"
			class="mb-3"
			v-if="form.shipping_message"
		>
			<div class="mb-0">
				<textarea
					class="form-control h-100"
					v-model="form.shipping_message"
					placeholder="Shipping"
				></textarea>
			</div>
		</FormFieldWrapper>
		<button class="btn btn-primary" @click="onSubmitForm">
			Save Changes
		</button>
	</AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { TOrder, TOrderForm } from '@/types/TOreder';
import { useForm } from '@inertiajs/vue3';
import FormFieldWrapper from '@/AdminComponents/FormFieldWrapper.vue';
import FormError from '@/AdminComponents/FormError.vue';
import useMessages from '@/modules/useMessages';

const { addMessage } = useMessages();

const props = defineProps<{ order: TOrder }>();
const { _t } = useTranslations();

const form = useForm<TOrderForm>({
	cart_content: props.order.cart_content,
	client_email: props.order.client_email,
	client_phone: props.order.client_phone,
	client_message: props.order.client_message,
	client_name: props.order.client_name,
	shipping_message: props.order.shipping_message,
	status_color: props.order.status_color,
	status_name: props.order.status_name,
	compleated: props.order.compleated === 1
});

const onSubmitForm = () => {
	form.clearErrors();
	form.put(route('admin.order.update', props.order.id), {
		preserveScroll: true,
		onSuccess: () => {},
		onError: () => {
			Object.entries(form.errors).forEach(([key, value]) => {
				addMessage({
					type: 'error',
					text: value
				});
			});
		}
	});
};
</script>

<style scoped></style>

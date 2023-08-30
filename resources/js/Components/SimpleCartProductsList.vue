<template>
	<div class="simple-cart-products-list fw-600">
		<div class="f- product lh-100" v-for="cartProduct in cartProducts">
			<strong class="mr-8"> {{ cartProduct.quantity }}x </strong>
			<p class="product-name mr-8">
				{{ _t(cartProduct.name) }}
			</p>
			<span class="color-secondary mr-8"> ₴{{ cartProduct.price }} </span>
			<button class="lh-0" @click="removeProductFromCart(cartProduct)">
				<img
					src="@/assets/cart-trash.svg"
					alt="Видалити"
					class="ml-8 mr-8"
				/>
			</button>
		</div>
	</div>
</template>

<script setup lang="ts">
import useCart from '@/composables/cart';

const { cartProducts, removeProductFromCart } = useCart();

const { _t, __ } = useTranslations();
</script>

<style scoped lang="scss">
.product {
	font-size: 15px;
	&:not(:last-child) {
		margin-bottom: 13px;
	}
}
.product-name {
	flex: 1;
	text-overflow: ellipsis;
	padding-right: 20px;
}
</style>

// Composable. cart products ref. Exports cartProducts ref and cartTotal computed property

import { ref, computed, watch, onMounted } from 'vue';
import { TProduct } from '@/types/TProduct';
import ICartProduct from '@/types/ICartProduct';

const cartProducts = ref<ICartProduct[]>([]);

const cartTotal = computed(() => {
	return cartProducts.value.reduce(
		(acc, product) => acc + product.price * product.quantity,
		0
	);
});

const addProductToCart = (product: TProduct, quantity: number = 1) => {
	const existingProduct = cartProducts.value.find(p => p.id === product.id);

	if (existingProduct) {
		existingProduct.quantity += quantity;
	} else {
		cartProducts.value.push({
			...product,
			quantity: quantity
		});
	}
};

const removeProductFromCart = (product: TProduct) => {
	cartProducts.value = cartProducts.value.filter(p => p.id !== product.id);
};

const removeEmptyProducts = () => {
	cartProducts.value = cartProducts.value.filter(p => p.quantity > 0);
};

const setProductQuantity = (product: TProduct, quantity: number) => {
	const existingProduct = cartProducts.value.find(p => p.id === product.id);

	if (existingProduct) {
		existingProduct.quantity = quantity;
	}

	removeEmptyProducts();
};

const isInCart = (product: TProduct) => {
	return cartProducts.value.some(p => p.id === product.id);
};
watch(
	cartProducts,
	() => {
		localStorage.setItem(
			'cartProducts',
			JSON.stringify(cartProducts.value)
		);
	},
	{ deep: true }
);
const setupCart = () => {
	onMounted(() => {
		const soredCartProducts = hasWindow()
			? localStorage.getItem('cartProducts')
			: null;

		if (soredCartProducts) {
			cartProducts.value = JSON.parse(soredCartProducts);
		}
	});
};

const resetCart = () => {
	cartProducts.value = [];

	localStorage.setItem('cartProducts', JSON.stringify([]));
};

export default function useCart() {
	return {
		cartProducts,
		cartTotal,
		addProductToCart,
		removeProductFromCart,
		setProductQuantity,
		setupCart,
		resetCart,
		isInCart
	};
}

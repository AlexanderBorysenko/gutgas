import { ref } from 'vue';
import useMainMenu from './mainMenu';

const isNavigationModalOpened = ref(false);
const toggleNavigationModal = () => {
	isNavigationModalOpened.value = !isNavigationModalOpened.value;

	// toggle lock html scroll
	if (isNavigationModalOpened.value) {
		document.documentElement.classList.add('lock');
	} else {
		document.documentElement.classList.remove('lock');
	}
};
const { items } = useMainMenu();

export default function useNavigationModal() {
	return {
		isNavigationModalOpened,
		toggleNavigationModal,
		items
	};
}

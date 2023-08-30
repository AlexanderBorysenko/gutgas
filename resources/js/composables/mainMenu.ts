import { computed, ref } from 'vue';

const useMainMenu = () => {
	const checkIsActive = (link: string) => {
		return hasWindow() && window.location.href.includes(link);
	};

	const items = computed(() => [
		{
			name: 'home',
			href: '/',
			isActive: hasWindow() && window.location.pathname === '/'
		},
		{
			name: 'Каталог балонів',
			href: '/catalog',
			isActive: checkIsActive('/catalog')
		},
		{
			name: 'Про компанію',
			href: '/about-us',
			isActive: checkIsActive('/about-us')
		},
		{
			name: 'Інструкції',
			href: '/',
			isActive: false
		}
	]);

	return {
		items
	};
};

export default useMainMenu;

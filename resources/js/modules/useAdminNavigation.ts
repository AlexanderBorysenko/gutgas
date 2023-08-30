import { computed } from 'vue';
import useAuth from './useAuth';

export type ISidebarMenu = [
	{
		title: string;
		icon: string;
		link: string;
		active: boolean;
		permited: boolean;
	}
];
export default function useAdminSidebarNavigation() {
	const { hasPermissions } = useAuth();

	const checkIsActive = (link: string) => {
		const currentLink = window.location.href + '/';
		return (
			currentLink.includes(link + '/') || currentLink.includes(link + '?')
		);
	};

	const items = computed(() => [
		{
			title: 'Home',
			icon: 'bi-house',
			link: route('admin.home'),
			permited: hasPermissions('admin.home'),
			active: window.location.href === route('admin.home')
		},
		// Order
		{
			title: 'Orders',
			icon: 'bi-cart',
			link: route('admin.order.index'),
			permited: hasPermissions('admin.order.index'),
			active: checkIsActive(route('admin.order.index'))
		},
		{
			title: 'Media',
			icon: 'bi-image',
			link: route('admin.mediaFile.index'),
			permited: hasPermissions('admin.mediaFile.index'),
			active: checkIsActive(route('admin.mediaFile.index'))
		},
		// Page
		{
			title: 'Pages',
			icon: 'bi-file-earmark-text',
			link: route('admin.page.indexAdmin'),
			permited: hasPermissions('admin.page.adminIndex'),
			active: checkIsActive(route('admin.page.indexAdmin'))
		},
		{
			title: 'Products',
			icon: 'bi-cart',
			link: route('admin.product.index'),
			permited: hasPermissions('admin.product.index'),
			active: checkIsActive(route('admin.product.index'))
		},
		// categories
		{
			title: 'Categories',
			icon: 'bi-list-ul',
			link: route('admin.category.index'),
			permited: hasPermissions('admin.category.index'),
			active: checkIsActive(route('admin.category.index'))
		},
		// productsGroups
		{
			title: 'Products Groups',
			icon: 'bi-list-ul',
			link: route('admin.productsGroup.indexAdmin'),
			permited: hasPermissions('admin.productsGroup.indexAdmin'),
			active: checkIsActive(route('admin.productsGroup.indexAdmin'))
		},
		// attribute groups
		{
			title: 'Attribute Groups',
			icon: 'bi-list-ul',
			link: route('admin.attributeGroup.index'),
			permited: hasPermissions('admin.attributeGroup.index'),
			active: checkIsActive(route('admin.attributeGroup.index'))
		},
		// requiredProductsGroup
		{
			title: 'Required Products Groups',
			icon: 'bi-list-ul',
			link: route('admin.requiredProductsGroup.index'),
			permited: hasPermissions('admin.requiredProductsGroup.index'),
			active: checkIsActive(route('admin.requiredProductsGroup.index'))
		},
		// global settings
		{
			title: 'Global Settings',
			icon: 'bi-gear',
			link: route('admin.globalSettings.index'),
			permited: hasPermissions('admin.globalSettings.index'),
			active: checkIsActive(route('admin.globalSettings.index'))
		},
		{
			title: 'Users',
			icon: 'bi-person-fill',
			link: route('admin.user.index'),
			permited: hasPermissions('admin.user.index'),
			active: checkIsActive(route('admin.user.index'))
		}
	]);

	return {
		items
	};
}

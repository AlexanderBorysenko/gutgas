import { IPaginated } from './IPaginated';
import { TAttributeGroup } from './TAttributeGroup';
import { TProduct } from './TProduct';
import { TProductsGroup } from './TProductsGroup';

export type TproductsCatalogData = {
	priceMin: number;
	priceMax: number;
	priceRange: {
		from: number;
		to: number;
	};
	products: IPaginated<TProduct>;
	attributeGroups: TAttributeGroup[];
	productsGroups: TProductsGroup[];
	appliedAttributes: number[];
	productsGroup: number;
	totalProductsCount: number;
};

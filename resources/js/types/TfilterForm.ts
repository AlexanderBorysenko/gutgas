export type TFilterForm = {
	selectedProductFilterValues: number[];
	productsGroup: number | null;
	priceRange: {
		from: number;
		to: number;
	};
};

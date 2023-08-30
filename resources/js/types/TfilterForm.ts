export type TfilterForm = {
	attributes: number[];
	productsGroup: number | null;
	priceRange: {
		from: number;
		to: number;
	};
};

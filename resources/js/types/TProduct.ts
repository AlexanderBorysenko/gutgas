import { IMediaFile } from './IMediaFile';
import { ITranslate } from './ITranslate';
import { TProductPage } from './TProductPage';
import { TProductsGroup } from './TProductsGroup';
import { TRequiredProductsGroup } from './TRequiredProductsGroup';
import { TSeoEntity } from './TSeoEntity';

export interface TProduct {
	id: number;
	name: ITranslate<string>;
	sku: string;
	price: number;
	stock: number;
	category_id: number | null;
	description: ITranslate<string>;
	media_file: IMediaFile | null;
	productPage?: TProductPage | null;
	products_groups?: TProductsGroup[];
	required_products_groups?: TRequiredProductsGroup[];
	seo_entity?: TSeoEntity;
}

export type TProductForm = {
	name: string;
	sku: string;
	price: number | null;
	stock: number | null;
	category_id: number | null;
	description: string;
	media_file: IMediaFile | null;
	attributes: number[];
	products_groups: number[];
	required_products_groups: number[];
};

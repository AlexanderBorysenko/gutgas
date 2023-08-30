import { IProductFilterAttributeOption } from './IProductFilterAttributeOption';

export interface IProductFilterAttribute {
	id: number;
	name: string;
	options: IProductFilterAttributeOption[];
}

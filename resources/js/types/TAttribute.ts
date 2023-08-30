import { ITranslate } from './ITranslate';
import { TAttributeGroup } from './TAttributeGroup';

export type TAttribute = {
	id: number;
	name: ITranslate<string>;
	attribute_group_id: number;
	attribute_group?: TAttributeGroup;
};

export type TAttributeForm = {
	name: string;
	attribute_group_id?: number;
};

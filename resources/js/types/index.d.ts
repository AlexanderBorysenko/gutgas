import { IUser } from './IUser';
import { TGlobalSetting } from './TGlobalSetting';

export type PageProps<
	T extends Record<string, unknown> = Record<string, unknown>
> = T & {
	auth: {
		user: IUser;
		permissions: string[];
	};
	message: {
		type: string;
		text: string;
	};
	globalSettings: TGlobalSetting[];
	baseUrl: string;
	search?: string;
	locale: string;
	locales: Record<string, string>;
	translations: Record<string, string>;
	breadcrumbs: {
		title: string;
		slug: string;
	}[];
};

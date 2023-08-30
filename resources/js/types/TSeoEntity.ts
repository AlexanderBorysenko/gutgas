export type TSeoEntity = {
	id: number;
	slug: string;
	title: string;
	description: string;
	og_image: string;
	controller: string;
	action: string;
};

export type TSeoEntityForm = {
	slug: string;
	title: string;
	description: string;
	og_image: string;
	controller?: string;
	action?: string;
};

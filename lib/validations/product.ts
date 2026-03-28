import { z } from "zod";

export const productSchema = z.object({
  name: z.string().min(3, "Nama beansnya harus minimal 3 karakter, bre"),
  description: z.string().min(10, "Deskripsi apaan ga sampe 10 karakter?"),
  price: z.coerce.number().min(1000, "Kopi apaan ga sampe 1000 bos?"),
  slug: z.string().min(3, "Slug gaboleh kosong"),
  image_url: z.string().url("Link fotonya harus valid URL"),
});

export type ProductInput = z.infer<typeof productSchema>;

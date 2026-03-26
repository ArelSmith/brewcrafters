"use server";

import { createSlug } from "@/lib/utils";
import { createProduct } from "@/services/product-services";
import { getAuthenticatedUserData } from "@/services/profile-services";
import { revalidatePath } from "next/cache";
import { redirect } from "next/navigation";

export const createNewProduct = async (formData: FormData) => {
  const { id } = await getAuthenticatedUserData();

  const rawData = {
    name: formData.get("name") as string,
    description: formData.get("description") as string,
    price: Number(formData.get("price")),
    slug: createSlug(formData.get("name") as string),
    image_url: (formData.get("image_url") as string) || "",
  };

  await createProduct(id, rawData);

  revalidatePath("/products");
  redirect("/products");
};

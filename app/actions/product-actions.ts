"use server";

import { createSlug } from "@/lib/utils";
import { createProduct, deleteProduct } from "@/services/product-services";
import { revalidatePath } from "next/cache";
import { redirect } from "next/navigation";

export const createNewProductAction = async (formData: FormData) => {
  const rawData = {
    name: formData.get("name") as string,
    description: formData.get("description") as string,
    price: Number(formData.get("price")),
    slug: createSlug(formData.get("name") as string),
    image_url: (formData.get("image_url") as string) || "",
  };

  createProduct(rawData);

  console.log(rawData);

  revalidatePath("/products");
  redirect("/products");
};

export const deleteProductAction = async (id: string) => {
  try {
    await deleteProduct(id);
    revalidatePath("/products");
    return redirect(
      "/products?message=" +
        encodeURIComponent("The product has deleted successfully"),
    );
  } catch (err) {
    console.error(err);
    return { error: "The product has not been deleted" };
  }
};

import { cache } from "react";
import { createClient } from "@/utils/supabase/server";

export interface Product {
  id: string;
  name: string;
  description: string;
  price: number;
  slug: string;
  image_url: string;
}

export const getProducts = cache(async () => {
  const supabase = await createClient();

  const { data, error } = await supabase.from("products").select("*");

  if (error) {
    console.error("Error fetching products:", error);
    return [];
  }
  return data;
});

export const getProductBySlug = cache(async (slug: string) => {
  const supabase = await createClient();

  const { data, error } = await supabase
    .from("products")
    .select("*")
    .eq("slug", slug)
    .single();

  if (error) {
    console.error("Error fetching product:", error);
    return null;
  }
  return data;
});

export const createProduct = async (
  id: string,
  formData: Omit<Product, "id">,
) => {
  const supabase = await createClient();

  const { data, error } = await supabase.from("products").insert({
    name: formData.name,
    description: formData.description,
    price: formData.price,
    slug: formData.slug,
    image_url: formData.image_url,
    user_id: id,
  });

  if (error) throw new Error(error.message);

  return data;
};

export const updateProduct = async (id: string, formData: Product) => {
  const supabase = await createClient();

  const { data, error } = await supabase
    .from("products")
    .update({
      name: formData.name,
      description: formData.description,
      price: formData.price,
      slug: formData.slug,
      image_url: formData.image_url,
    })
    .eq("id", id);

  if (error) throw new Error(error.message);

  return data;
};

export const deleteProduct = async (id: string) => {
  const supabase = await createClient();

  const { error } = await supabase.from("products").delete().eq("id", id);

  if (error) throw new Error(error.message);

  return true;
};

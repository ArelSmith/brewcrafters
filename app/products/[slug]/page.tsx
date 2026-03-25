import Image from "next/image";
import { notFound } from "next/navigation";
import { getProductBySlug } from "@/services/product-services";
import { formatPrice } from "@/lib/utils";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge"; // optional kalau ada kategori
import { ShoppingCart, ArrowLeft } from "lucide-react";
import Link from "next/link";

export default async function ProductDetailPage({
  params,
}: {
  params: Promise<{ slug: string }>;
}) {
  const { slug } = await params;
  const product = await getProductBySlug(slug);

  if (!product) {
    notFound(); // Balik ke page 404 krem lo tadi
  }

  return (
    <main className="max-w-6xl mx-auto px-4 py-12 md:py-20">
      {/* Back Button */}
      <Link
        href="/products"
        className="flex items-center gap-2 text-sm text-muted-foreground hover:text-primary mb-8 transition-colors"
      >
        <ArrowLeft className="w-4 h-4" />
        Back to Catalog
      </Link>

      <div className="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
        {/* KIRI: IMAGE SECTION */}
        <div className="relative aspect-square overflow-hidden rounded-[2.5rem] shadow-2xl border-4 border-white">
          <Image
            src={
              product.image_url ||
              "https://dummyimage.com/800x800/4e342e/ffffff&text=Brew+Beans"
            }
            alt={product.name}
            fill
            className="object-cover hover:scale-105 transition-transform duration-500"
            priority
          />
        </div>

        {/* KANAN: CONTENT SECTION */}
        <div className="flex flex-col h-full justify-center">
          <div className="space-y-6">
            <header>
              <Badge
                variant="outline"
                className="mb-4 border-primary text-primary px-3 py-1 rounded-full uppercase tracking-wider text-[10px]"
              >
                Premium Collection
              </Badge>
              <h1 className="text-4xl md:text-5xl font-bold text-[#4e342e] leading-tight">
                {product.name}
              </h1>
              <p className="text-2xl font-semibold text-primary mt-4">
                {formatPrice(product.price)}
              </p>
            </header>

            <div className="h-px w-full bg-gray-200" />

            <article>
              <h3 className="font-semibold mb-2 text-sm uppercase tracking-widest text-gray-400">
                Description
              </h3>
              <p className="text-gray-600 leading-relaxed text-lg">
                {product.description ||
                  "No description available for this special blend yet. Stay tuned!"}
              </p>
            </article>

            {/* CTA BUTTONS */}
            <div className="flex flex-col sm:flex-row gap-4 pt-8">
              <Button
                size="lg"
                className="flex-1 h-14 rounded-full bg-primary hover:bg-primary/90 text-white gap-2 text-lg shadow-lg shadow-primary/20"
              >
                <ShoppingCart className="w-5 h-5" />
                Add to Cart
              </Button>
              <Button
                size="lg"
                variant="outline"
                className="flex-1 h-14 rounded-full border-primary text-primary hover:bg-primary/5 text-lg"
              >
                Quick Brew Guide
              </Button>
            </div>
          </div>
        </div>
      </div>
    </main>
  );
}

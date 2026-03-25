import { createClient } from "@/utils/supabase/server";
import { Button } from "@/components/ui/button";
import {
  Card,
  CardAction,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";
import Image from "next/image";
import { formatPrice } from "@/lib/utils";
import Link from "next/link";
import { getProducts } from "@/services/product-services";

const ProductPage = async () => {
  const data = await getProducts();
  return (
    <div className="max-w-10/12 mx-auto mt-25">
      <h1 className="text-5xl font-bold text-center">Products</h1>
      {data && data.length > 0 ? (
        <div className="flex flex-wrap mt-10">
          {data.map((product, index) => (
            <Card className="relative mx-auto w-full max-w-sm pt-0" key={index}>
              <div className="absolute inset-0 z-30 aspect-video bg-black/35" />
              <Image
                src="https://dummyimage.com/600x400/000/fff"
                alt="Event cover"
                className="relative z-20 aspect-video w-full object-cover brightness-60 grayscale dark:brightness-40"
                width={600}
                height={400}
                loading="eager"
              />
              <CardHeader>
                <CardAction></CardAction>
                <CardTitle>{product.name}</CardTitle>
                <CardDescription>{formatPrice(product.price)}</CardDescription>
              </CardHeader>
              <CardFooter className="flex flex-row flex-wrap">
                <Link href={`/products/${product.slug}`} className="w-auto">
                  <Button className="w-auto">View Details</Button>
                </Link>

                <Button variant="outline" className="w-auto">
                  Add to Cart
                </Button>
              </CardFooter>
            </Card>
          ))}
        </div>
      ) : (
        <p>No products available.</p>
      )}
    </div>
  );
};

export default ProductPage;

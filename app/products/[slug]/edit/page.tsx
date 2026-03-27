import { Button } from "@/components/ui/button";
import { createNewProductAction } from "@/app/actions/product-actions";

export const metadata = { title: "Add New Product" };

export default function EditProductPage() {
  return (
    <main className="max-w-2xl mx-auto p-6 bg-white rounded-xl shadow-sm mt-10">
      <h1 className="text-2xl font-bold mb-6 text-gray-800">
        New Brew Selection ☕️
      </h1>

      <form action={createNewProductAction} className="flex flex-col gap-5">
        <div className="flex flex-col gap-2">
          <label className="text-sm font-medium">Product Name</label>
          <input
            name="name"
            placeholder="Ex: Sweet Mango Blues"
            className="border p-2 rounded-md outline-accent"
          />
        </div>

        <div className="flex flex-col gap-2">
          <label className="text-sm font-medium">Price (IDR)</label>
          <input
            name="price"
            type="number"
            placeholder="50000"
            min="10000"
            className="border p-2 rounded-md outline-accent"
          />
        </div>

        <div className="flex flex-col gap-2">
          <label className="text-sm font-medium">Image URL (Optional)</label>
          <input
            name="image_url"
            placeholder="https://..."
            className="border p-2 rounded-md outline-accent"
          />
        </div>

        <div className="flex flex-col gap-2">
          <label className="text-sm font-medium">Description</label>
          <textarea
            name="description"
            rows={4}
            placeholder="Explain the notes, origin, etc..."
            className="border p-2 rounded-md outline-accent"
          />
        </div>

        <div className="flex gap-4 mt-2">
          <Button type="submit" className="flex-1 bg-accent hover:bg-accent/90">
            Post Product
          </Button>
        </div>
      </form>
    </main>
  );
}

import { createClient } from "@/utils/supabase/server";
import { Button } from "@/components/ui/button";

const TestPage = async () => {
  const supabase = await createClient();
  const { data: products, error } = await supabase.from("products").select("*");

  if (error) {
    return <div>Error: {error.message}</div>;
  }

  return (
    <main>
      {products?.map((item) => (
        <div key={item.id}>
          <h2>{item.name}</h2>
          <Button className="bg-blue-600">Add to Cart</Button>
        </div>
      ))}
    </main>
  );
};

export default TestPage;

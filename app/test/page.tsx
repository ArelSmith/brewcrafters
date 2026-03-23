import { createClient } from "@/utils/supabase/server";

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
        </div>
      ))}
    </main>
  );
};

export default TestPage;

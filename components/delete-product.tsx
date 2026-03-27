"use client";

import { useTransition } from "react";
import { deleteProductAction } from "@/app/actions/product-actions";
import { Button } from "./ui/button";

const DeleteProductButton = ({ id }: { id: string }) => {
  const [isPending, startTransition] = useTransition();

  return (
    <Button
      disabled={isPending}
      variant="destructive"
      onClick={() => {
        if (confirm("Hapus beans ini?")) {
          startTransition(async () => {
            await deleteProductAction(id);
          });
        }
      }}
      className="flex-1 h-14 rounded-full border-primary text-primary hover:bg-primary/5 text-lg"
    >
      {isPending ? "Sabar..." : "Hapus"}
    </Button>
  );
};

export default DeleteProductButton;

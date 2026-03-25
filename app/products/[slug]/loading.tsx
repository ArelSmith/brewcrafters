import { Loader2 } from "lucide-react";

export default function Loading() {
  return (
    <div className="flex h-[80vh] w-full items-center justify-center">
      <div className="flex flex-col items-center gap-4">
        {/* Spinner dengan warna primary cokelat lo */}
        <Loader2 className="h-12 w-12 animate-spin text-primary" />

        {/* Teks opsional biar user tau lagi ngapain */}
        <p className="text-sm font-medium text-primary animate-pulse">
          Lagi nyiapin produk mu, sabar ya...
        </p>
      </div>
    </div>
  );
}

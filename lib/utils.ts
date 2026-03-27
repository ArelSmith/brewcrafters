import { clsx, type ClassValue } from "clsx";
import { twMerge } from "tailwind-merge";

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs));
}

export function formatPrice(price: number | null | undefined): string {
  if (price === null || price === undefined) return "Rp0,-";
  const formatter = new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  });

  return `${formatter.format(price)},-`.replace(/\s/g, "");
}

export function createSlug(title: string): string {
  return title
    .toString()
    .toLowerCase()
    .trim()
    .replace(/\s+/g, "-") // Ganti spasi sama strip (-)
    .replace(/[^\w-]+/g, "") // Hapus semua karakter non-word (simbol dll)
    .replace(/--+/g, "-") // Ganti double strip jadi satu strip
    .replace(/^-+/, "") // Hapus strip di awal teks
    .replace(/-+$/, "");
}

export function now(): string {
  return new Date().toISOString();
}

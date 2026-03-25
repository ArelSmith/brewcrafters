import Link from "next/link";

export async function generateMetadata() {
  return {
    title: "Not Found - Brewcrafters",
    description: "Halaman yang lo cari nggak ketemu, Rel.",
  };
}

export default function NotFound() {
  return (
    <div className="min-h-screen bg-[#fff3ef] flex flex-col items-center justify-center text-[#4e342e] p-4">
      <h2 className="text-4xl font-bold mb-4 italic">Oops! Kopi Tumpah.</h2>
      <p className="mb-8">Halaman yang lo cari nggak ketemu, Rel.</p>
      <Link
        href="/"
        className="bg-[#4e342e] text-white px-6 py-2 rounded-full hover:bg-[#4e342e]/90 transition-all"
      >
        Balik ke Beranda ya! (Home)
      </Link>
    </div>
  );
}

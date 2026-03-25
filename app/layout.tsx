import type { Metadata } from "next";
import { Poppins } from "next/font/google";
import "./globals.css";
import { cn } from "@/lib/utils";
import Navbar from "@/components/shared/navbar";
import { createClient } from "@/utils/supabase/server";

const poppins = Poppins({
  variable: "--font-poppins",
  weight: "500",
});
export const metadata: Metadata = {
  title: "Home - Brewcrafters",
  description:
    "Discover the finest selection of craft beers at Brewcrafters. Explore our curated collection of unique brews, from hoppy IPAs to rich stouts. Whether you're a seasoned beer enthusiast or just starting your craft beer journey, Brewcrafters has something for everyone. Cheers to great taste and unforgettable moments with Brewcrafters!",
};

export default async function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  const supabase = await createClient();
  const {
    data: { user },
  } = await supabase.auth.getUser();

  return (
    <html
      lang="en"
      className={cn("h-full", "antialiased", "font-sans", poppins.variable)}
    >
      <body className={cn("min-h-full flex flex-col ", poppins.className)}>
        <Navbar initialUser={user} />
        <div className="mt-20">{children}</div>
      </body>
    </html>
  );
}

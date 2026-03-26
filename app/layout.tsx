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
  title: {
    template: "%s - Brewcrafters",
    default: "Brewcrafters", // a default is required when creating a template
  },
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

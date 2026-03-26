"use client";

import Link from "next/link";
import { createClient } from "@/utils/supabase/client";
import { Button } from "../ui/button";
import { useState, useEffect } from "react";
import { logout } from "@/app/actions/auth-actions";
import { User } from "@supabase/supabase-js";
import {
  NavigationMenu,
  NavigationMenuItem,
  NavigationMenuLink,
  NavigationMenuList,
  NavigationMenuViewport,
} from "@/components/ui/navigation-menu";

import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { ChevronDown } from "lucide-react"; // Import icon panah

interface NavbarProps {
  initialUser: User | null;
}

const Navbar = ({ initialUser }: NavbarProps) => {
  const [user, setUser] = useState<User | null>(initialUser);
  const supabase = createClient();

  useEffect(() => {
    const {
      data: { subscription },
    } = supabase.auth.onAuthStateChange((event, session) => {
      setUser(session?.user ?? null);
    });

    return () => subscription.unsubscribe();
  }, [supabase]);

  return (
    <header className="h-20 px-4 fixed top-0 left-0 right-0 backdrop-blur-sm z-50 ">
      <nav className="flex h-full max-w-10/12 mx-auto justify-between items-center">
        {/* 1. Brand/Logo */}
        <h1 className="text-2xl font-semibold drop-shadow-6xl">
          <Link href="/">
            <span className="text-accent">Brew</span>crafters.
          </Link>
        </h1>

        {/* 2. Main Menu (Tengah) */}
        <NavigationMenu className="hidden md:block">
          {" "}
          {/* Sembunyiin di HP kalau mau */}
          <NavigationMenuList className="flex gap-4 list-none">
            <NavigationMenuItem>
              <NavigationMenuLink asChild>
                <Link href="/" className="hover:text-accent transition">
                  Home
                </Link>
              </NavigationMenuLink>
            </NavigationMenuItem>
            <NavigationMenuItem>
              <NavigationMenuLink asChild>
                <Link href="/about" className="hover:text-accent transition">
                  About Us
                </Link>
              </NavigationMenuLink>
            </NavigationMenuItem>
            <NavigationMenuItem>
              <NavigationMenuLink asChild>
                <Link href="/products" className="hover:text-accent transition">
                  Products
                </Link>
              </NavigationMenuLink>
            </NavigationMenuItem>
            <NavigationMenuItem>
              <NavigationMenuLink asChild>
                <Link href="/blogs" className="hover:text-accent transition">
                  Blogs
                </Link>
              </NavigationMenuLink>
            </NavigationMenuItem>
          </NavigationMenuList>
          <NavigationMenuViewport />
        </NavigationMenu>

        {/* 3. User Actions (Kanan) */}
        <div className="flex items-center gap-4">
          {user ? (
            <div className="flex items-center gap-3 pl-4 border-gray-400">
              <DropdownMenu>
                <DropdownMenuTrigger className="flex items-center gap-1 hover:text-accent transition outline-none cursor-pointer">
                  {user.user_metadata?.username || "brewer"}
                  <ChevronDown className="h-4 w-4" />
                </DropdownMenuTrigger>

                <DropdownMenuContent align="end" className="w-48 p-2">
                  <DropdownMenuLabel>My Account</DropdownMenuLabel>
                  <DropdownMenuSeparator />

                  <DropdownMenuItem asChild className="cursor-pointer">
                    <Link href="/dashboard" className="w-full">
                      Dashboard
                    </Link>
                  </DropdownMenuItem>

                  <DropdownMenuSeparator />

                  <DropdownMenuItem className="p-0">
                    <form action={logout} className="w-full">
                      <Button
                        variant="destructive"
                        className="w-full text-left px-2 py-1.5 text-sm transition hover:cursor-pointer"
                      >
                        Logout
                      </Button>
                    </form>
                  </DropdownMenuItem>
                </DropdownMenuContent>
              </DropdownMenu>
            </div>
          ) : (
            <>
              <Link href="/login">
                <Button className="p-5 rounded-3xl hover:cursor-pointer">
                  Sign In
                </Button>
              </Link>
            </>
          )}
        </div>
      </nav>
    </header>
  );
};

export default Navbar;

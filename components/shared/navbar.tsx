"use client";

import Link from "next/link";
import { createClient } from "@/utils/supabase/client";
import { Button } from "../ui/button";
import { useState, useEffect } from "react";
import { logout } from "@/app/auth/actions";
import { User } from "@supabase/supabase-js";
import {
  NavigationMenu,
  NavigationMenuItem,
  NavigationMenuLink,
  NavigationMenuList,
  NavigationMenuTrigger,
  NavigationMenuContent,
  NavigationMenuViewport,
} from "@/components/ui/navigation-menu";

const Navbar = () => {
  const [user, setUser] = useState<User | null>(null);
  const supabase = createClient();

  useEffect(() => {
    const fetchUser = async () => {
      const {
        data: { user },
      } = await supabase.auth.getUser();
      setUser(user);
    };

    fetchUser();

    const {
      data: { subscription },
    } = supabase.auth.onAuthStateChange((event, session) => {
      setUser(session?.user ?? null);
    });

    return () => subscription.unsubscribe();
  }, [supabase]);

  return (
    <header className="h-20 px-4">
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
          <NavigationMenuList className="flex gap-4">
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
              <NavigationMenuTrigger>Products</NavigationMenuTrigger>
              <NavigationMenuContent>
                <ul className="grid w-100 gap-3 p-4">
                  <li>Item 1</li>
                  <li>Item 2</li>
                </ul>
              </NavigationMenuContent>
            </NavigationMenuItem>
            <NavigationMenuItem>
              <NavigationMenuLink asChild>
                <Link href="/blog" className="hover:text-accent transition">
                  Blog
                </Link>
              </NavigationMenuLink>
            </NavigationMenuItem>
          </NavigationMenuList>
          <NavigationMenuViewport />
        </NavigationMenu>

        {/* 3. User Actions (Kanan) */}
        <div className="flex items-center gap-4">
          {user ? (
            <div className="flex items-center gap-3 border-l pl-4 border-gray-400">
              {/* <span className="text-sm font-medium italic">
                @{user.user_metadata?.username || "brewer"}
              </span>
              <form action={logout}>
                <Button variant="destructive" size="sm" type="submit">
                  Logout
                </Button>
              </form> */}
              <NavigationMenu>
                <NavigationMenuItem>
                  <NavigationMenuTrigger>
                    {user.user_metadata?.username || "brewer"}
                  </NavigationMenuTrigger>
                  <NavigationMenuContent>
                    <ul className="grid w-100 gap-3 p-4 decoration-none">
                      <li>Dashboard</li>
                      <li>
                        <form action={logout}>
                          <Button variant="destructive" size="sm" type="submit">
                            Logout
                          </Button>
                        </form>
                      </li>
                    </ul>
                  </NavigationMenuContent>
                </NavigationMenuItem>
              </NavigationMenu>
            </div>
          ) : (
            <Link href="/login">
              <Button
                variant="default"
                className="p-5 rounded-3xl hover:cursor-pointer"
              >
                Sign In
              </Button>
            </Link>
          )}
        </div>
      </nav>
    </header>
  );
};

export default Navbar;

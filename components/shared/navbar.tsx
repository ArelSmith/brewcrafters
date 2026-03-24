"use client";

import Link from "next/link";
import { createClient } from "@/utils/supabase/client";
import { Button } from "../ui/button";
import { useState, useEffect } from "react";
import { logout } from "@/app/auth/actions";
import { User } from "@supabase/supabase-js";

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
    <header>
      <nav className="bg-green-400">
        {/* Header */}
        <h1 className="text-2xl">
          <Link href="/">Home</Link>
          {user ? (
            <>
              <span className="mx-2">|</span>
              <span>{user.user_metadata?.username}</span>
              <form action={logout}>
                <Button type="submit">Logout</Button>
              </form>
            </>
          ) : null}
        </h1>
      </nav>
    </header>
  );
};

export default Navbar;
